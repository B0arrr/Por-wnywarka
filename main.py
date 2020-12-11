from selenium import webdriver
from bs4 import BeautifulSoup
import requests
import json

def fill_link(data):
    tmp = data['name'].replace(' ', '+')

    driver = webdriver.Chrome()

    href = 'https://store.steampowered.com/search/?term='

    url = href + tmp

    driver.get(url)

    link = driver.find_element_by_id('search_resultsRows').find_element_by_css_selector('a').get_attribute('href')

    data['link'] = link


def fill_prize(data):
    url = data['link']

    request = requests.get(url)

    query = BeautifulSoup(request.text, 'html.parser')

    temp = query.find(class_='game_area_purchase_game')

    tmp = temp.find(class_='discount_prices')

    if tmp is None:
        tmp = query.find(class_='game_purchase_price price').text.replace(' ', '').replace('\t', '')\
            .replace('\n', '').replace('\r', '')
        data['price'] = tmp
        return

    tmp = temp.find(class_='discount_final_price').text.replace(' ', '').replace('\t', '')\
        .replace('\n', '').replace('\r', '')
    data['price'] = tmp


with open('games.json', encoding='UTF-8') as file:
    data = json.load(file)

    for p in data['steam']:
        if p['link'] == '':
            fill_link(p)
        fill_prize(p)

with open('games.json', 'w', encoding='UTF-8') as file:
    json.dump(data, file, ensure_ascii=False)
