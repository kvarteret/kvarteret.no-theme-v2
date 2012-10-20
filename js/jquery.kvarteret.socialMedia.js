
function socialMedia(url) {
	console.log('Getting social media share counts for: ' + url);
	// Get number of Tweets for this article
	$.getJSON('http://urls.api.twitter.com/1/urls/count.json?url='+url+'&callback=?',
    function(data) {
		var tweets = 0;
		if('count' in data && data.count > 0) {
			tweets = data.count;
			console.log('Tweets: ' + data.count);
			$('.twitter_share').append('<div class="count">' + tweets + '</div>');
		}
        
	});
	
	// Get number of Likes (Shares + likes + mentions)
	$.getJSON('http://graph.facebook.com/?id='+url+'&callback=?',
    function(data) {
		var shares = 0;
		if('shares' in data && data.shares > 0) {
			shares = data.shares;
			console.log('Likes: ' + data.shares);
			 $('.facebook_share').append('<div class="count">' + shares + '</div>');
		}
       
	});
}	