import json
import requests
from lxml import etree
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.wait import WebDriverWait

shops = ['steam', 'epicgames']

file_name = 'games.json'

def main():
    global data_keys
    data = load()

    try:
        data_keys = data.keys()
    except:
        pass

    if not data:
        make_dict(data, shops)
    for i in shops:
        if not compare_keys(i, data_keys):
            update_shop(data, i)

    # print(len(data['steam']))
    # print(len(data['epicgames']))

    # update_file(data, 'steam')

    # update_all_prices(data)

    print_data(data)


def get_page_numbers(title):
    return {
        'steam': 1
    }[title]


def get_url(title):
    return {
        'steam': 'https://store.steampowered.com/search/?page=',
        'epicgames': 'https://www.epicgames.com/store/pl/browse?sortBy=releaseDate&sortDir=DESC&pageSize=25'
    }[title]


def get_xpath_for_name(title):
    return {
        'steam': "//span[@class='title']",
        'epicgames': "//*[@class='css-2ucwu']"
    }[title]


def get_xpath_for_link(title):
    return {
        'steam': "//*[@id= 'search_resultsRows']/a[@href]",
        'epicgames': "//li[@class= 'css-1adx3p4-BrowseGrid-styles__card']/a[@href]"
    }[title]


def get_xpath_for_price(title):
    return {
        'steam': "//*[@class='col search_price_discount_combined responsive_secondrow']/div[2]",
        'epicgames': "//*[@class='css-ovezyj']"
    }[title]


def get_xpath_for_loading_page(title):
    return {
        'steam': '//div[@class="search_pagination"]'
    }[title]


def get_xpath_for_confirm_entry(title):
    return {
        'epicgames': "//*[@class='css-19tmzba']",
        'steam': '//div[@class="agegate_text_container btns"]/a'
    }[title]


def get_xpath_for_category(title):
    return {
        'epicgames': "//div[@class='css-1nilh6d']/div[4]/div/div/div/div/span",
        'epicgames_2': "//div[@class='css-1sqot86']/div[4]/div/div/div/div/span",
        'steam': '//div[@class="glance_tags popular_tags"]/a'
    }[title]


def get_xpath_for_producent(title):
    return {
        'steam': '//div[@class="dev_row"]/div[2]',
        'epicgames': '//div[@class="css-1a9lf9m-GameMeta-styles__listData"]'
    }[title]


def get_xpath_for_wait(title):
    return {
        'epicgames': "//div[@class='css-1wd5p3d-TwoColumnGroup__right']",
        'steam': '//div[@class="game_background_glow"]'
    }[title]


def fill_shop_with_pages(driver, title, names, prices, links, page_count):
    for i in range(page_count):
        driver.get(get_url(title) + str(i+1))
        counter = 0
        name_query = driver.find_elements_by_xpath(get_xpath_for_name(title))
        for j in name_query:
            names.append(j.text.replace('\u2122', '').replace('\u00ae', ''))
        link_query = driver.find_elements_by_xpath(get_xpath_for_link(title))
        for k in link_query:
            links.append(k.get_attribute('href'))
        price_query_p = driver.find_elements_by_xpath(get_xpath_for_price(title))
        for l in price_query_p:
            a = ''
            child = ''
            try:
                child = l.find_element_by_tag_name("span").text
                a = l.text.replace(child, '').replace('\n', '')
            except:
                a = l.text
            prices.append(a)


def fill_shop(driver, title, names, prices, links):
    driver.get(get_url(title))
    WebDriverWait(driver, 30).until(EC.presence_of_element_located((By.XPATH, get_xpath_for_name(title))))
    name_query = driver.find_elements_by_xpath(get_xpath_for_name(title))
    link_query = driver.find_elements_by_xpath(get_xpath_for_link(title))
    price_query = driver.find_elements_by_xpath(get_xpath_for_price(title))

    for i, j, k in zip(name_query, price_query, link_query):
        names.append(i.text.replace('\u2122', '').replace('\u00ae', ''))
        prices.append(j.text)
        links.append(k.get_attribute('href'))


def fill_categories_and_producent(driver, title, link, categories, producent):
    categories.clear()
    driver.get(link)

    producent[0] = ''
    query_categories = ''

    try:
        if title == 'steam':
            select = driver.find_element_by_xpath('//select[@id="ageYear"]')
            option = select.find_elements_by_tag_name('option')
            for i in option:
                if i.text == '2000':
                    i.click()
            driver.find_element_by_xpath(get_xpath_for_confirm_entry(title)).click()
        else:
            driver.find_element_by_xpath(get_xpath_for_confirm_entry(title)).click()
    except:
        pass

    try:
        WebDriverWait(driver, 3).until(EC.presence_of_element_located((By.XPATH, get_xpath_for_wait(title))))
    except:
        pass

    try:
        query_categories = driver.find_elements_by_xpath(get_xpath_for_category(title))
    except:
        pass

    if len(query_categories) is 0:
        try:
            query_categories = driver.find_elements_by_xpath(get_xpath_for_category(title+'_2'))
        except:
            pass

    try:
        query_producent = driver.find_element_by_xpath(get_xpath_for_producent(title))
        tmp = query_producent.text.split(', ')
        producent[0] = tmp[0]
    except:
        pass

    for i in query_categories:
        if i.text == '':
            break
        categories.append(i.text)


def fill(driver, title, names, prices, links):
    if title == 'steam':
        fill_shop_with_pages(driver, title, names, prices, links, get_page_numbers(title))
    else:
        fill_shop(driver, title, names, prices, links)


def make_dict(data, shops):
    driver = webdriver.Chrome()
    for i in shops:
        data[i] = []
        names = []
        prices = []
        links = []
        categories = []
        producent = ['']
        fill(driver, i, names, prices, links)
        for j, k, l in zip(names, prices, links):
            if k == 'Free to Play' or k == 'Bezpłatne' or k == '':
                continue
            fill_categories_and_producent(driver, i, l, categories, producent)
            data[i].append({'name': j, 'price': k, 'link': l, 'categories': list(categories), 'producent': producent[0]})
    driver.quit()
    save(data)


def save(data):
    with open(file_name, 'w', encoding='UTF-8') as file:
        json.dump(data, file, ensure_ascii=False)


def load():
    try:
        with open(file_name) as file:
            tmp = json.load(file)
            return tmp
    except:
        f = open(file_name, 'w', encoding='UTF-8')
        f.write('{}')
        f.close()
        return {}


def print_data(data):
    print(json.dumps(data, indent=2))


def fix_string(string):
    tmp = str(string)
    return tmp.replace('\r', '').replace('\n', '').replace('\t', '')


# def update_prices_no_js(title, obj):
#     page = requests.get(obj['link'])
#     query = etree.HTML(page.content)
#     price = query.xpath(get_xpath_for_normal_price(title))
#
#     if not price:
#         price = query.xpath(get_xpath_for_discount_price(title))
#     obj['price'] = fix_string(price[0])


# def update_prices(title, obj):
#     try:
#         driver = webdriver.Chrome()
#         driver.get(obj['link'])
#         query = driver.find_element_by_xpath(get_xpath_for_normal_price(title))
#         if query is None:
#             query = driver.find_element_by_xpath(get_xpath_for_discount_price(title))
#         obj['price'] = query.text
#     except:
#         obj['price'] = ''


# def update_all_prices(data):
#     for i in data:
#         for j in data[i]:
#             if i == 'steam':
#                 update_prices_no_js(i, j)
#             else:
#                 update_prices(i, j)
#     # save(data)


def update_shop(data, title):
    data.update({title: []})
    driver = webdriver.Chrome()
    names = []
    prices = []
    links = []
    categories = []
    producents = ['']
    fill(driver, title, names, prices, links)
    for j, k, l in zip(names, prices, links):
        if k == 'Free to Play' or k == 'Bezpłatne' or k == '':
            continue
        fill_categories_and_producent(driver, title, l, categories, producents)
        data[title].append({'name': j, 'price': k, 'link': l, 'categories': list(categories), 'producent': producents[0]})
    driver.quit()
    save(data)


def compare_keys(title, keys):
    tmp = 0
    for i in keys:
        if i == title:
            tmp += 1
    if tmp == 0:
        return False
    return True


# def update_file():


# def fill_prices(data, shops):


if __name__ == "__main__":
    main()