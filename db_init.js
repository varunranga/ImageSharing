db = connect('127.0.0.1:27017/CCBD_USER')
db.CCBD_USER.drop()

db = connect('127.0.0.1:27017/CCBD_USER')

db = connect('127.0.0.1:27017/CCBD_POST')
db.CCBD_POST.drop()

db = connect('127.0.0.1:27017/CCBD_POST')

db = connect('127.0.0.1:27017/CCBD_GLOBAL')
db.CCBD_GLOBAL.drop()

db = connect('127.0.0.1:27017/CCBD_GLOBAL')
db.CCBD_GLOBAL.insert({"user_count":0, "post_count":0})