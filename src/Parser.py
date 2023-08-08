from bs4 import BeautifulSoup
import requests
import urllib.parse
import codecs

FILE_ADDRESS = "G:/XAMPP/htdocs/cities-game/cities.txt"

alphabet = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЭЮЯ'

cities = []

for i in range(len(alphabet)):
    category = urllib.parse.quote(alphabet[i])
    uri = "https://ru.wikinews.org/w/index.php?title=%D0%9A%D0%B0%D1%82%D0%B5%D0%B3%D0%BE%D1%80%D0%B8%D1%8F:%D0%93%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%BF%D0%BE_%D0%B0%D0%BB%D1%84%D0%B0%D0%B2%D0%B8%D1%82%D1%83&from=" + category
    src = requests.get(uri)
    soup = BeautifulSoup(src.text, "lxml")

    page = soup.find_all("div", {"class": "CategoryTreeItem"})

    for i in page:
        city = (i.find("a").text).strip()
        space = city.find(' ') + 1

        if space != 0:
            city = city[:space].strip()

        if city not in cities:
            cities.append(city)


with codecs.open('cities.txt', 'w', 'utf-8') as file:
    for city in cities:
        file.write(city + '\n')