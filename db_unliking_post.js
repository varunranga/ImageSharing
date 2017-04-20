var db = connect('127.0.0.1:27017/CCBD_POST')

// var post_id
// var user_id

post = db.CCBD_POST.find({"post_id":post_id}).toArray()[0]
post['liked'].splice(post['liked'].indexOf(user_id), 1)
post['number_of_likes'] -= 1

db.CCBD_POST.update({"post_id":post_id}, post)