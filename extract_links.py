from selenium import webdriver
import requests
from bs4 import BeautifulSoup
import time
links_info=[]
visited_url=[]
current_milli_time = lambda: int(round(time.time() * 1000))
dead_links=0
images_above_100=0
images_below_100=0
def recursive_links_extract(url):
	before_time=current_milli_time()
	response=requests.head(url,headers={'User-Agent': 'Chrome'})
	visited_url.append(url)
	after_time = current_milli_time()
	time_elapsed=after_time-before_time
	if response.status_code!=200:
		links_info.append((url,"Unreachable"))
		dead_links=dead_links+1
	else:
		resp_head=response.headers
		length=-1#if content length infp is not present
		if 'Content-Length' in resp_head:
			length=resp_head['Content-Length']
		links_info.append((url,"Reachable",length,time_elapsed))
		print ('Content-Type' in resp_head)
		if 'Content-Type' in resp_head and resp_head['Content-Type'].startswith("text/html"):
			page=requests.get(url)
			html_doc=page.text
			soup=BeautifulSoup(html_doc,'lxml')
			all_links=soup.find_all('a')
			all_images=soup.find_all('img')
			for each_link in all_links:
				print (each_link)
				if each_link['href'] in visited_url:
					continue
				recursive_links_extract(each_link['href'])
			for each_link in all_images:
				if each_link['src'] in visited_url:
					continue
				recursive_links_extract(each_link['src'])
		if 'Content-Type' in resp_head and resp_head['Content-Type'].startswith('image'):
			if 'Content-Type' in resp_head:
				if resp_head['Content-Length']>100000:
					images_above_100=images_above_100+1
				else:
					images_below_100=images_below_100+1
url=input()
recursive_links_extract(url)
print (links_info)		
print (images_below_100)
print (images_above_100)