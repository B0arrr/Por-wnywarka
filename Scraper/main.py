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
    data = load()

    data_keys = data.keys()

    if not data:
        make_dict(data, shops)
    for i in shops:
        if not compare_keys(i, data_keys):
            update_shop(data, i)

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
        'epicgames': 'https://www.epicgames.com/store/pl/browse?sortBy=releaseDate&sortDir=DESC&pageSize=1000'
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
        'steam': "//*[@class='col search_price  responsive_secondrow']",
        'epicgames': "//*[@class='css-ovezyj']"
    }[title]


def get_xpath_for_price_discounted(title):
    return {
        'steam': "//*[@class='col search_price discounted responsive_secondrow']",
        'epicgames': "//*[@class='css-ovezyj']"
    }[title]


def get_xpath_for_normal_price(title):
    return {
        'steam': "//div[@class='game_purchase_action']/div/div[@class='game_purchase_price price']/text()",
        'epicgames': "//*[@class='css-8v8on4']"
    }[title]


def get_xpath_for_discount_price(title):
    return {
        'steam': "//div[@class='game_purchase_action_bg']/div/div/div[@class='discount_final_price']/text()",
        'epicgames': "//*[@class='css-8v8on4']"
    }[title]


def get_xpath_for_confirm_entry(title):
    return {
        'epicgames': "//*[@class='css-19tmzba']"
    }[title]


def fill_shop_with_pages(driver, title, names, prices, links, page_count):
    for i in range(page_count):
        driver.get(get_url(title) + str(i+1))
        name_query = driver.find_elements_by_xpath(get_xpath_for_name(title))
        link_query = driver.find_elements_by_xpath(get_xpath_for_link(title))
        price_query = driver.find_elements_by_xpath(get_xpath_for_price(title))
        if price_query is None:
            price_query = driver.find_elements_by_xpath(get_xpath_for_price_discounted(title))

        for j, k, l in zip(name_query, price_query, link_query):
            names.append(j.text)
            prices.append(k.text)
            links.append(l.get_attribute('href'))


def fill_shop(driver, title, names, prices, links):
    driver.get(get_url(title))
    WebDriverWait(driver, 30).until(EC.presence_of_element_located((By.XPATH, get_xpath_for_name(title))))
    name_query = driver.find_elements_by_xpath(get_xpath_for_name(title))
    link_query = driver.find_elements_by_xpath(get_xpath_for_link(title))
    price_query = driver.find_elements_by_xpath(get_xpath_for_price(title))
    if price_query is None:
        price_query = driver.find_elements_by_xpath(get_xpath_for_price_discounted(title))

    for i, j, k in zip(name_query, price_query, link_query):
        names.append(i.text)
        prices.append(j.text)
        links.append(k.get_attribute('href'))


def fill_names(title, names, prices, links):
    driver = webdriver.Chrome()
    if title == 'steam':
        fill_shop_with_pages(driver, title, names, prices, links, get_page_numbers(title))
    else:
        fill_shop(driver, title, names, prices, links)


def make_dict(data, shops):
    for i in shops:
        data[i] = []
        names = []
        prices = []
        links = []
        fill_names(i, names, prices, links)
        for j, k, l in zip(names, prices, links):
            data[i].append({'name': j, 'price': k, 'link': l})
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
        f = open(file_name, 'w')
        f.write('{}')
        f.close()
        main()


def print_data(data):
    print(json.dumps(data, indent=2))


def fix_string(string):
    tmp = str(string)
    return tmp.replace('\r', '').replace('\n', '').replace('\t', '')


def update_prices_no_js(title, obj):
    page = requests.get(obj['link'])
    query = etree.HTML(page.content)
    price = query.xpath(get_xpath_for_normal_price(title))

    if not price:
        price = query.xpath(get_xpath_for_discount_price(title))
    obj['price'] = fix_string(price[0])


def update_prices(title, obj):
    try:
        driver = webdriver.Chrome()
        driver.get(obj['link'])
        query = driver.find_element_by_xpath(get_xpath_for_normal_price(title))
        if query is None:
            query = driver.find_element_by_xpath(get_xpath_for_discount_price(title))
        obj['price'] = query.text
    except:
        obj['price'] = ''


def update_all_prices(data):
    for i in data:
        for j in data[i]:
            if i == 'steam':
                update_prices_no_js(i, j)
            else:
                update_prices(i, j)
    save(data)


def update_shop(data, title):
    data.update({title: []})
    names = []
    prices = []
    links = []
    fill_names(title, names, prices, links)
    for j, k, l in zip(names, prices, links):
        data[title].append({'name': j, 'price': k, 'link': l})
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