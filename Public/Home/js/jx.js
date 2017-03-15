$(function(){
	$(".select-ab").click(function(){
		var ref=$(this);
		ref.toggleClass("on");
		ref.siblings(".select-item").slideToggle();
		var other_parent=ref.parent(".city-select").siblings();
		other_parent.find(".select-item").hide();
		other_parent.find(".select-ab").removeClass("on");
	})
//选择城市页面下拉框的隐藏和显示
	$(".select-item p,.city0,.city-hot li").click(function(){
		var txt=$(this).text();
		$(".city0").text(txt);
		if (typeof clickafter == 'function') {
			clickafter(txt);
		}
	})
//选择城市页面点击选择定位城市

	$(".take-photo").click(function(){
		$(".bg-black").show();
		$(".report-box").show();
	})
	$(".fake-head span").on('click',function () {
		history.go(-1);
	})
})
