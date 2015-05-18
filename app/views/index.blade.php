@include('partials.header')

<div class="row">
    <div class="col-xs-12">
        <form method="post" class="form-inline">
            <div class="form-group">
                <p class="form-control-static">I want to rate: </p>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="animal" value="dog" checked="checked"> Dogs
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="animal" value="cat" > Cats
                </label>
            </div>
            <div class="form-group">
                <p class="form-control-static">from: </p>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="zipcode" />
            </div>
            <input type="submit" class="btn btn-primary btn-lg" />
        </form>
    </div>

    <div class="col-xs-12">
        <h1>Top Rated</h1>
        <h3>Top Too Cute</h3>
        <div class="row">
            @foreach($top_cute as $pet)
                <div class="col-xs-3">
                    <?php $photos = $pet->getPhotos(); ?>
                        <a href="{{ url('top/cute/'.$pet->pet_id) }}"><img src="{{ $photos[0] }}" class="img-responsive" /></a>
                    <h5><a href="{{ url('top/cute/'.$pet->pet_id) }}">{{ $pet->name }}</a></h5>
                </div>
            @endforeach
            <div class="col-xs-3">
                <p>See More -></p>
            </div>
        </div>
        <h3>Top Needs Love</h3>
        <div class="row">
            @foreach($top_love as $pet)
                <div class="col-xs-3">
                    <?php $photos = $pet->getPhotos(); ?>
                    <a href="{{ url('top/love/'.$pet->pet_id) }}"><img src="{{ $photos[0] }}" class="img-responsive" /></a>
                    <h5><a href="{{ url('top/love/'.$pet->pet_id) }}">{{ $pet->name }}</a></h5>
                </div>
            @endforeach
            <div class="col-xs-3">
                <p>See More -></p>
            </div>
        </div>
        <h3>Top So Tuff</h3>
        <div class="row">
            @foreach($top_tuff as $pet)
                <div class="col-xs-3">
                    <?php $photos = $pet->getPhotos(); ?>
                    <a href="{{ url('top/cute/'.$pet->pet_id) }}"><img src="{{ $photos[0] }}" class="img-responsive" /></a>
                    <h5><a href="{{ url('top/cute/'.$pet->pet_id) }}">{{ $pet->name }}</a></h5>
                </div>
            @endforeach
            <div class="col-xs-3">
                <p>See More -></p>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')