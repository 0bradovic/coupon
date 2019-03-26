@if (\Session::has('success'))

   <div class="alert alert-success" style="text-align:center;">

       <ul style="list-style:none;">

           <li>{!! \Session::get('success') !!}</li>

       </ul>

   </div>
   
@endif