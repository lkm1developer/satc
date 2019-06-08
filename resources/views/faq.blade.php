@extends('layouts.layoutpage')
@section('content')
<div class="main_head_faq m_hgt">
@include('slider')
<div class="outer-div-sh">
  <div class="container">
    <div class="inner-box-sh">
   <div class="page-haeading">
      <h2>FAQ</h2>
      <p>If you are unable to find an answer to your question, join the Discord and speak with one of the <b>Developers.</b> We will be more than happy to assist you with any problem you have regarding your masternode.
      </p>
   </div>
   <div class="row panel-group" id="accordion">
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">What is the Satoshi Solutions?</a>
               </h4>
            </div>
            <div class="panel-body">
               <p>Satoshi Solution was build to assist novice users with creating and running a masternode. In a few simple steps you can have your masternode of the supported coins up and running without having to deal with repositories, VPS servers and linux commands.
               </p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">How does it work?</a>
               </h4>
            </div>
            <div class="panel-body">
               <p>Satoshi Solutions automatically creates and configures the masternode server for you in the background. At certain points you will be asked for 
                  input that links your wallet to the masternode server.
               </p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven">How much does it cost?</a>
               </h4>
            </div>
            <div class="panel-body">
               <?php $Setting =  App\Setting::find(1);
                     ?>
               <p>Each masternode server you launch on Satoshi Solutions will cost $0{{$Setting->hosting_rate}} charged in SATC ({{$Setting->rate}} SATC ) daily. Price based on GRAVIEX. The Fee will be automatically withdrawn from your account daily. It is your responsibility to monitor your SATC balance.</p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Where are the masternodes hosted?</a>
               </h4>
            </div>
            <div class="panel-body">
               <p> Each masternode is launched on our own datacenter servers and not on Vultr or DigitalOcean like other platforms. This alllows us to have full control of the servers which allows for a more faster automated platform and cheaper fees for our customers.
               </p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Are my coins safe with you?</a>
               </h4>
            </div>
            <div class="panel-body">
               <p>SatoshiSolutions uses a cold wallet setup, which means your coins will never leave your personal wallet and will be always under your full control.
               </p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">What happens if I forget to replenish my platform balance?</a>
               </h4>
            </div>
            <div class="panel-body">
               <p>In case we can not deduct the daily payment from your platform balance the servers in your account get destroyed. </p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix"> What happens in case of server failure?</a>
               </h4>
            </div>
            <div class="panel-body">
               <p>First attempt to restart your masternode by going to the Mastenode tab in your wallet and select the masternode and select Start alias. If that does not work, contact one of the <b>Developers</b> on Discord and we will help you get your server up and running.
               </p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">What happens when my server gets destroyed?</a>
               </h4>
            </div>
            <div class="panel-body">
               <p>We will allow for the respawn of the same server, although the same IP address is not guaranteed to be available, case in which you will need a tiny bit of configuration in your wallet to change this IP address.
               </p>
               <div class="serial-no"></div>
            </div>
         </div>
      </div>
     
   </div>
</div>
</div>
</div>
</div>
@include('layouts.footer')
@endsection