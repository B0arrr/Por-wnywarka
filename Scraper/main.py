import json
import requests
from lxml import etree
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.wait import WebDriverWait

shops = ['gog']
file_name = 'games.json'

def main():
    global data_keys
    data = load()

    try:
        data_keys = data.keys()
    except:
        pass

    appended_shops = []

    for i in shops:
        if not compare_keys(i, data_keys):
            append_shop(data, i)
            appended_shops.append(i)

    # for i in shops:
    #     if i in str(appended_shops):
    #         continue
    #     update_prices(i, data)

    print(len(data['gog']))

    print_data(data)


def get_page_numbers(title):
    return {
        'steam': 1,
        'gog': 1
    }[title]


def get_url(title):
    return {
        'steam': 'https://store.steampowered.com/search/?page=',
        'epicgames': 'https://www.epicgames.com/store/pl/browse?sortBy=releaseDate&sortDir=DESC&pageSize=25',
        'gog': 'https://www.gog.com/games?page='
    }[title]


def get_xpath_for_name(title):
    return {
        'steam': "//span[@class='title']",
        'epicgames': "//*[@class='css-2ucwu']",
        'gog': '//div[@class="product-tile__title"]'
    }[title]


def get_xpath_for_link(title):
    return {
        'steam': "//*[@id= 'search_resultsRows']/a[@href]",
        'epicgames': '//li[@class="css-18gst1e-BrowseGrid-styles__card"]/a',
        'gog': '//a[@class="product-tile__content js-content"]'
    }[title]


def get_xpath_for_img_link(title):
    return {
        'steam': "//*[@id= 'search_resultsRows']/a/div/img",
        'epicgames': '//li[@class="css-18gst1e-BrowseGrid-styles__card"]/a/div/div/div/div/div/img',
        'gog': '//a[@class="product-tile__content js-content"]/div[2]/picture/img'
    }[title]


def get_attribute_for_img_link(title):
    return {
        'epicgames': 'data-image',
        'steam': 'src',
        'gog': 'src'
    }[title]


def get_xpath_for_price(title):
    return {
        'steam': "//*[@class='col search_price_discount_combined responsive_secondrow']/div[2]",
        'epicgames': "//*[@class='css-ovezyj']",
        'gog': '//span[@class="product-tile__price-discounted _price"]'
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
        'steam': '//div[@class="glance_tags popular_tags"]/a',
        'gog': '//div[@class="details table table--without-border"]/div[1]/div/a'
    }[title]


def get_xpath_for_producent(title):
    return {
        'steam': '//div[@class="dev_row"]/div[2]',
        'epicgames': '//div[@class="css-1a9lf9m-GameMeta-styles__listData"]',
        'gog': '//div[@class="details table table--without-border"]/div[4]/div/a[1]'
    }[title]


def get_xpath_for_wait(title):
    return {
        'epicgames': "//div[@class='css-1wd5p3d-TwoColumnGroup__right']",
        'steam': '//div[@class="game_background_glow"]',
        'gog': '//div[@class="layout-container"]'
    }[title]


def get_xpath_for_update_price(title):
    return {
        'steam': '//div[@class="game_purchase_action_bg"]/div[@class="game_purchase_price price"]',
        'steam_2': '//div[@class="game_purchase_action_bg"]/div/div[2]/div[2]',
        'epicgames': '//span[@class="css-8v8on4"]',
        'epicgames_2': '//span[@class="css-ovezyj"]',
        'gog': '//span[@class="product-actions-price__final-amount _price ng-binding"]'
    }[title]


def get_xpath_for_update_wait(title):
    return {
        'epicgames': "//div[@class='css-1a9lf9m-GameMeta-styles__listData'",
        'steam': '//div[@class="game_purchase_action"]',
        'gog': '//span[@class="product-actions-price__final-amount _price ng-binding"]'
    }[title]


def fill_shop_with_pages(driver, title, names, prices, links, img_links, page_count):
    for i in range(page_count):
        driver.get(get_url(title) + str(i+1))
        WebDriverWait(driver, 30).until(EC.presence_of_element_located((By.XPATH, get_xpath_for_name(title))))
        name_query = driver.find_elements_by_xpath(get_xpath_for_name(title))
        for j in name_query:
            if j.is_displayed():
                names.append(j.text.replace('\u2122', '').replace('\u00ae', ''))
        link_query = driver.find_elements_by_xpath(get_xpath_for_link(title))
        for k in link_query:
            if k.is_displayed():
                links.append(k.get_attribute('href'))
        img_link_query = driver.find_elements_by_xpath(get_xpath_for_img_link(title))
        for k in img_link_query:
            if k.is_displayed():
                img_links.append(k.get_attribute(get_attribute_for_img_link(title)))
        price_query_p = driver.find_elements_by_xpath(get_xpath_for_price(title))
        for l in price_query_p:
            if l.is_displayed():
                a = ''
                child = ''
                try:
                    child = l.find_element_by_tag_name("span").text
                    a = l.text.replace(child, '').replace('\n', '')
                except:
                    a = l.text
                a.replace('zł', '').replace(' ', '')
                prices.append(a)


def fill_shop(driver, title, names, prices, links, img_links):
    driver.get(get_url(title))
    WebDriverWait(driver, 30).until(EC.presence_of_element_located((By.XPATH, get_xpath_for_name(title))))
    name_query = driver.find_elements_by_xpath(get_xpath_for_name(title))
    link_query = driver.find_elements_by_xpath(get_xpath_for_link(title))
    img_link_query = driver.find_elements_by_xpath(get_xpath_for_img_link(title))
    price_query = driver.find_elements_by_xpath(get_xpath_for_price(title))

    for i, j, k, l in zip(name_query, price_query, link_query, img_link_query):
        names.append(i.text.replace('\u2122', '').replace('\u00ae', ''))
        prices.append(j.text.replace('zł', '').replace(' ', '').replace('\n', ''))
        links.append(k.get_attribute('href'))
        img_links.append(l.get_attribute(get_attribute_for_img_link(title)))


def fill_categories_and_producent(driver, title, link, categories, producent):
    categories.clear()
    driver.get(link)

    producent[0] = ''
    query_categories = ''

    entry(title, driver)

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


def fill(driver, title, names, prices, links, img_links):
    if title == 'steam' or title == 'gog':
        fill_shop_with_pages(driver, title, names, prices, links, img_links, get_page_numbers(title))
    else:
        fill_shop(driver, title, names, prices, links, img_links)


def save(data):
    with open(file_name, 'w', encoding='UTF-8') as file:
        json.dump(data, file, ensure_ascii=False)


def load():
    try:
        with open(file_name, encoding='UTF-8') as file:
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


def update_prices(title, data):
    driver = webdriver.Chrome()

    for i in data[title]:
        driver.get(i['link'])

        entry(title, driver)

        try:
            WebDriverWait(driver, 3).until(EC.presence_of_element_located((By.XPATH, get_xpath_for_update_wait(title))))
        except:
            pass


        price = ''

        try:
            query = driver.find_element_by_xpath(get_xpath_for_update_price(title))
            price = query.text
        except:
            pass

        if price is '':
            try:
                query = driver.find_element_by_xpath(get_xpath_for_update_price(title+'_2'))
                price = query.text
            except:
                pass

        price.replace('\n', '').replace('zł', '').replace(' ', '')
        if i['price'] is not price:
            i['price'] = price
    save(data)
    driver.quit()


def append_shop(data, title):
    data.update({title: []})
    driver = webdriver.Chrome()
    names = []
    prices = []
    links = []
    img_links = []
    categories = []
    producents = ['']
    fill(driver, title, names, prices, links, img_links)
    for j, k, l, m in zip(names, prices, links, img_links):
        if k == 'Free to Play' or k == 'Bezpłatne' or k == '' or k == 'Za darmo':
            continue
        fill_categories_and_producent(driver, title, l, categories, producents)
        data[title].append({'name': j, 'price': k, 'link': l, 'img': m, 'categories': list(categories), 'producent': producents[0]})
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


def entry(title, driver):
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


if __name__ == "__main__":
    main()
