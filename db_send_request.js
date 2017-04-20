var db = connect('127.0.0.1:27017/CCBD_USER')

// var send_id
// var receive_id


// For the sender
send_user = db.CCBD_USER.find({"user_id":send_id}).toArray()[0]
send_user['requested'].push(receive_id)

db.CCBD_USER.update({"user_id":send_id}, send_user)

// For the receiver
receive_user = db.CCBD_USER.find({"user_id":receive_id}).toArray()[0]
receive_user['pending_requests'].push(send_id)

db.CCBD_USER.update({"user_id":receive_id}, receive_user)
