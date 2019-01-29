<!--footer area start-->
<style>
.text-center1,p,.fmenu{
    
    color:#fff;
}
.clawn li,a{
    
    color:#fff;
}


</style>
<section class="bg3"> 
	<nav class="menusection navbar-inverse" style="background-color: #293d3d;padding: 25px;">
    	 <div class="container-fluid">
            <div class="gpe_utilMenu"> 
                <ul class="list-inline text-center clawn"> 
                    <li> 
                        <a href="#"> About Us</a> 
                    </li> 
                    <li> 
                        <a href="#"> Ask Us</a>
                    </li>
                    <li>
                         <a href="#"> Terms &amp; Conditions</a> 
                    </li> 
                    <li>
                         <a href="#"> Privacy Policy</a>
                    </li>
                    <li> 
                         <a href="#"> Disclaimer</a> 
                    </li> 
                    <li> 
                        <a href="#"> Safety Rule</a> 
                    </li> 
                    <li> 
                        <a href="#"> Help Center</a>
                    </li> 
                    <li> 
                        <a href="#"> Site Map</a>
                    </li>
                </ul> 
            </div>
      </div>
	</nav>
</section>
<footer class="footer-area" style="background: #293d3d;padding: 0px 0px 39px 0px;">
    <div class="">
        
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <div class="footer-menu">
                        <ul class="list-inline">
                            <li>
                                <p>소재지: 795 Folsom Ave, Suite 600 San Francisco, CA 94107 / 대표전화: +1 614-9222-0392 / 팩스: (91) 11 4752 1433
</p>
                                <p class="copyright-text ">
                                     {!! $basic->copyright !!}
                                </p>
                            </li>
                        </ul>
                        <ul class="list-inline">
                             @foreach($social as $data)
                            <li> <a href="{{url($data->link)}}" style="font-size: 18px">{!! $data->code !!}</a></li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="back-to-top" class="scroll-top back-to-top" data-original-title="" title="" >
        <i class="fa fa-angle-up"></i>
    </div>
</footer>