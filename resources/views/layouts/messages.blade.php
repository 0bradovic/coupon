@if (\Session::has('success'))

   <div class="alert alert-success" style="text-align:center;position:relative;">
   <div class="close-msg"><i class="fas fa-times"></i></div>
       <ul style="list-style:none;">

           <li>{!! \Session::get('success') !!}</li>

       </ul>

   </div>
   
@endif