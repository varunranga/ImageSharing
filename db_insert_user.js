var db = connect('127.0.0.1:27017/CCBD_USER')

var json = {
	'user_id' : user_id,
	'first_name' : first_name,
	'last_name' : last_name,
	'email_id' : email_id,
	'phone_number' : phone_number,
	'city' : city,
	'state' : state,
	'country' : country,
	'password' : password,
	'profile_picture' : profile_picture,
	'friends' : [],
	'pending_requests' : [],
	'requested' : [],
	'posts_on_newsfeed' : [] 
}

var search = db.CCBD_USER.find({"email_id":json['email_id']}).toArray()[0]
if (search != undefined)
{
	printjson({"problem":"Email ID already exists!"})
}
else
{
	db.CCBD_USER.insert(json)
	printjson(json)

	var db = connect('127.0.0.1:27017/CCBD_GLOBAL')

	var user_count = db.CCBD_GLOBAL.find().toArray()[0]['user_count']
	var post_count = db.CCBD_GLOBAL.find().toArray()[0]['post_count']
	user_count += 1

	db.CCBD_GLOBAL.update({"post_count":post_count}, {"user_count":user_count, "post_count":post_count})
}
// mongo --eval "var user_id='USR001'; var first_name='Varun'; var last_name='Ranganathan'; var email_id='varunranga1997@hotmail.com'; var phone_number='8722817699'; var city='Bangalore'; var state='Karnataka'; var country='Bangalore'; var password='varunmeenu'; var profile_picture='profile_pictures/USR001'" db_insert_user.js