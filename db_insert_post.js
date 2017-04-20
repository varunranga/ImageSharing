var db = connect('127.0.0.1:27017/CCBD_POST')

var json = {
	'user_id' : user_id,
	'post_id' : post_id,
	'post_picture' : post_picture,
	'description' : description,
	'number_of_likes' : 0,
	'liked' : []
}

printjson(json)

db.CCBD_POST.insert(json)

// Now to update on friends 'posts_on_newsfeed'

var db = connect('127.0.0.1:27017/CCBD_USER')

var user = db.CCBD_USER.find({"user_id":user_id}).toArray()[0]
user['posts_on_newsfeed'].push(post_id)

db.CCBD_USER.update({"user_id":user_id}, user)

var friends = db.CCBD_USER.find({"user_id":user_id}).toArray()[0]['friends']
for (var i = friends.length - 1; i >= 0; i--) {
	friend_id = friends[i]

	var friend = db.CCBD_USER.find({"user_id":friend_id}).toArray()[0]
	friend['posts_on_newsfeed'].push(post_id)

	db.CCBD_USER.update({"user_id":friend_id}, friend)
}


var db = connect('127.0.0.1:27017/CCBD_GLOBAL')

var user_count = db.CCBD_GLOBAL.find().toArray()[0]['user_count']
var post_count = db.CCBD_GLOBAL.find().toArray()[0]['post_count']
post_count += 1

db.CCBD_GLOBAL.update({"user_count":user_count}, {"user_count":user_count, "post_count":post_count})

// mongo --eval "var user_id='USR4'; var post_id='PST1'; var post_picture='post_pictures/PST1'; var description='Testing if this works!';" db_insert_post.js