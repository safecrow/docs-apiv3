require 'curb'
require 'openssl'
require 'json'

api_key    = "**** YOUR API KEY ****"
api_secret = "**** YOUR API SECRET ****"

# GET method exmaple 

prefix   = '/api/v3'
endpoint = '/users?email=test@example.com'

data = api_key + "GET" + prefix + endpoint

c = Curl::Easy.new('https://dev.safecrow.ru' + prefix + endpoint)
c.headers['Content-Type'] = 'application/json'
c.http_auth_types = :basic
c.username = api_key
c.password = OpenSSL::HMAC.hexdigest('SHA256', api_secret, data)
c.perform

puts c.status
puts c.body

# POST method exmaple 

prefix   = '/api/v3'
endpoint = '/users'

user = { email: 'test@example.com' }
data = api_key + "POST" + prefix + endpoint + user.to_json

c = Curl::Easy.new('https://dev.safecrow.ru' + prefix + endpoint)
c.headers['Content-Type'] = 'application/json'
c.http_auth_types = :basic
c.username = api_key
c.password = OpenSSL::HMAC.hexdigest('SHA256', api_secret, data)
c.post(user.to_json)

puts c.status
puts c.body
