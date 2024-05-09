{{-- <div id="image" style="">
    <img src="{{$membrete}}" style="top: -160px; left: -5px; position:fixed; z-index: -9999; height: 1045px; max-height: 1045px; width: 805px; max-width: 805px">
</div> --}}
{{-- echo '<img src="data:image/png;base64,' . base64_encode($membrete) .'" style="top: -160px; left: -5px; position:fixed; z-index: -9999; height: 1045px; max-height: 1045px; width: 805px; max-width: 805px">'; --}}


{{-- top: -155px; position: fixed; height: 2200px; width: 800px; z-index: -9999; background-repeat: no-repeat;background-size: 100%; --}}
{{-- <div class="img-background"></div> --}}


<style>
    #image {
        position: fixed;
        margin-left: -9px ;
        top: -164px;
        height: 2500px;
        width: 815px;
        z-index: -9999;
        
        background-image: url({{$membrete}});
        background-repeat: no-repeat;
        background-size: contain;
    }
</style>
<div id="image">
</div>