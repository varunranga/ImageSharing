var db = connect('127.0.0.1:27017/CCBD_POST')

// var post_id
// var user_id

post = db.CCBD_POST.find({"post_id":post_id},{"_id":0}).toArray()[0]
post['liked'].push(user_id)
post['number_of_likes'] += 1

db.CCBD_POST.update({"post_id":post_id}, post)

var db = connect('127.0.0.1:27017/CCBD_USER')
var user = db.CCBD_USER.find({"user_id":user_id}).toArray()[0]
if (user['posts_on_newsfeed'].indexOf(post_id) == -1)
{
	user['posts_on_newsfeed'].push(post_id)
	db.CCBD_USER.update({"user_id":user_id}, user)
}