import hmac
import hashlib
import requests
import json
from requests.auth import HTTPBasicAuth


api_key    =  "**** YOUR API KEY ****"
api_secret = b"**** YOUR API SECRET ****"

# GET method example

prefix   = "/api/v3"
endpoint = "/users?email=test@gmail.com"

data = (api_key + "GET" + prefix + endpoint).encode('utf-8')

hm = hmac.new(api_secret, data, hashlib.sha256).hexdigest()
response = requests.get('https://dev.safecrow.ru' + prefix + endpoint, 
		        auth=HTTPBasicAuth(api_key, hm),
			headers = {'Content-Type': 'application/json'})
print(response)
print(response.text)

# POST method example

user     = json.dumps({ 'email' : 'test@example.com' })
prefix   = "/api/v3"
endpoint = "/users"

data = (api_key + "POST" + prefix + endpoint + user).encode('utf-8')

hm = hmac.new(api_secret, data, hashlib.sha256).hexdigest()
response = requests.post('https://dev.safecrow.ru' + prefix + endpoint, 
		        auth=HTTPBasicAuth(api_key, hm),
			data = user,
			headers = {'Content-Type': 'application/json'})
print(response)
print(response.text)
