@if (\Session::has('success'))

   <div class="alert alert-success">

       <ul style="list-style:none;">

           <li>{!! \Session::get('success') !!}</li>

       </ul>

   </div>
   
@endif