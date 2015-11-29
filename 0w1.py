import requests
import json
import sys

def getSite():

	headers = {
		'Host': '0w1.xyz',
		'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:42.0) Gecko/20100101 Firefox/42.0',
		'Accept': '*/*',
		'Accept-Language': 'tr-TR,tr;q=0.8,en-US;q=0.5,en;q=0.3',
		'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
		'X-Requested-With': 'XMLHttpRequest',
		'Referer': 'http://0w1.xyz/',
		'Connection': 'keep-alive',
		'Pragma': 'no-cache',
		'Cache-Control': 'no-cache',
	}

	site = input('Site Adresi: ')

	if not (site.startswith('http://') or site.startswith('https://')):
		print('Site adresi http:// ya da https:// ile başlamalıdır')
		sys.exit(1)

	data = 'url={0}'.format(site)

	r = requests.post('http://0w1.xyz/ajax.php', headers=headers, data=data)

	jsonDecode = json.loads(r.text)

	print("Short URL:", jsonDecode['url'])
	print("Site URL:", jsonDecode['site_url'])


getSite()
