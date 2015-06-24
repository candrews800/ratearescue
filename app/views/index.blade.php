@include('partials.header')

<header id="home-page">
    <div id="banner-bg">
        <i class="fa fa-paw"></i>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-7 col-xs-offset-5">
                <div id="logo">
                    Rate A Rescue
                </div>
                <form method="post">
                    <p class="form-text">FIND</p>

                    <div class="radio">
                        <div>
                            <input id="option-dog" type="radio" name="animal" value="dog" checked="checked">
                            <label for="option-dog"><span><span></span></span>Dogs</label>
                        </div>
                        <div>
                            <input id="option-cat" type="radio" name="animal" value="cat">
                            <label for="option-cat"><span><span></span></span>Cats</label>
                        </div>
                    </div>

                    <p class="form-text">NEAR</p>
                    <div class="form-group">
                        <input type="text" name="zipcode" placeholder="Zipcode" class="input-lg"/>
                    </div>


                    <input type="submit" value="Go" class="btn btn-success btn-lg" />
                </form>
            </div>
        </div>
    </div>
</header>

<section id="top-animals">
    <div class="top clearfix">
        <h3>Top Cute</h3>
        <div class="img-spinner">
            <div class="left">
                <i class="fa fa-caret-left"></i>
            </div>
            @foreach($top_cute as $key=>$pet)
                <?php $photos = $pet->getPhotos(); ?>
            <div class="outer" style="left: <?php echo $key * 265;?>px">
                <a href="{{ url('top/cute/'.$pet->pet_id) }}">
                    <img src="{{ $photos[0] }}" />
                </a>
            </div>
            @endforeach
            <div class="right">
                <i class="fa fa-caret-right"></i>
            </div>
        </div>
    </div>
    <div class="top clearfix">
        <h3>Top Tuff</h3>
        <div class="img-spinner">
            <div class="left">
                <i class="fa fa-caret-left"></i>
            </div>
            @foreach($top_tuff as $key=>$pet)
                <?php $photos = $pet->getPhotos(); ?>
                <div class="outer" style="left: <?php echo $key * 265;?>px">
                    <a href="{{ url('top/tuff/'.$pet->pet_id) }}">
                        <img src="{{ $photos[0] }}" />
                    </a>
                </div>
            @endforeach
            <div class="right">
                <i class="fa fa-caret-right"></i>
            </div>
        </div>
    </div>
    <div class="top clearfix">
        <h3>Top Tiny</h3>
        <div class="img-spinner">
            <div class="left">
                <i class="fa fa-caret-left"></i>
            </div>
            @foreach($top_tiny as $key=>$pet)
                <?php $photos = $pet->getPhotos(); ?>
                <div class="outer" style="left: <?php echo $key * 265;?>px">
                    <a href="{{ url('top/tiny/'.$pet->pet_id) }}">
                        <img src="{{ $photos[0] }}" />
                    </a>
                </div>
            @endforeach
            <div class="right">
                <i class="fa fa-caret-right"></i>
            </div>
        </div>
    </div>
    <div class="top clearfix">
        <h3>Top Happy</h3>
        <div class="img-spinner">
            <div class="left">
                <i class="fa fa-caret-left"></i>
            </div>
            @foreach($top_happy as $key=>$pet)
                <?php $photos = $pet->getPhotos(); ?>
                <div class="outer" style="left: <?php echo $key * 265;?>px">
                    <a href="{{ url('top/happy/'.$pet->pet_id) }}">
                        <img src="{{ $photos[0] }}" />
                    </a>
                </div>
            @endforeach
            <div class="right">
                <i class="fa fa-caret-right"></i>
            </div>
        </div>
    </div>
</section>


@include('partials.footer')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>
    var hoverInterval;
    $(function(){
        $(".left").hover(function(){
            var spinner = $(this).parent();

            hoverInterval = setInterval(function(){
                var imgs = spinner.find('.outer');

                if(parseInt($(imgs[0]).css('left')) < 0){
                    $(imgs).each(function(value){
                        var leftPos = parseInt($(this).css('left'));
                        $(this).css({left: leftPos + 3});
                    });
                }
            }, 10);
        }, function(){
            clearInterval(hoverInterval);
        });

        $(".right").hover(function(){
            var spinner = $(this).parent();

            hoverInterval = setInterval(function(){
                var imgs = spinner.find('.outer');

                if(parseInt($(imgs[imgs.length-1]).css('left') + $(imgs[imgs.length-1]).width() + 10) > window.innerWidth - 30){
                    $(imgs).each(function(value){
                        var leftPos = parseInt($(this).css('left'));
                        $(this).css({left: leftPos - 3});
                    });
                }
            }, 10);
        }, function(){
            clearInterval(hoverInterval);
        });
    });
</script>