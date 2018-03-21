<div class="message-block">
    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">
        @if(is_array(Session::get('error')))
            <ul>
            @foreach(Session::get('error') as $error)
                @if(count($error) >= 2)
                    @foreach($error as $err)
                        <li>{{$err}}</li>
                    @endforeach
                @else
                    <li>{{ implode("</li><li>",$error) }}</li>
                @endif
            @endforeach
            </ul>
        @else
            <p>{{{ Session::get('error') }}}</p>
        @endif
        </div>
    @endif
     <!-- check for flash notification message -->
    @if(Session::has('notice'))
        <div class="alert alert-info" role="alert">
            <p>{{ Session::get('notice') }}</p>
        </div>
    @endif
    
     <!-- check for flash notification message -->
    @if(Session::has('success'))
     <div class="alert alert-success">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    	{{ Session::get('success') }}
  	</div>
       
    @endif
</div>