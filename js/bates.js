function test() {
		var data = { color: "black", size: 23 };
		jQuery.ajax({
				url: 'ajax.php',
				data: data,
				success: function(data, status, jqXHR) {
						console.log("received " + data);
				},
				error: function(jqXHR, status, error) {
						console.log("error: " + status);
				},
		});
}
