@if (count($report->imageEvidence()) == 0)
	<div class="item active">
		<img src={{ asset('plugins/images/transp-image5.png')}} alt="$evidence->multimedia_path" data-toggle="modal" data-target="#responsive-modal_{{$report->id}}">
	</div>
@else
	<div id="responsive-modal_{{$report->id}}" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	    <div class="modal-dialog" style="left:-20%;width:80%;top:10%;padding:0px;margin-top:0px;">
	        <div class="modal-content" style="padding-bottom:0px;margin-top:0px;">
	            <div class="modal-body">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <div id="myModalCarousel_{{$report->id}}" class="carousel slide" data-ride="carousel">

					  <!-- Wrapper for slides -->
					  <div class="carousel-inner">
					  	@foreach ($report->imageEvidence() as $modal_evidence)
							<div class="item {{ $loop->first ? 'active' : ' '}}">
						      <img src="{{ asset('evidence/'.$report->id.'/'.$modal_evidence->multimedia_path) }}" alt="$modal_evidence->multimedia_path">
						    </div>
						@endforeach
					  </div>

					 @if (count($report->imageEvidence()) > 1)
						  <!-- Left and right controls -->
						  <a class="left carousel-control" href="#myModalCarousel_{{$report->id}}" data-slide="prev">
						    <span class="glyphicon glyphicon-chevron-left"></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="right carousel-control" href="#myModalCarousel_{{$report->id}}" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right"></span>
						    <span class="sr-only">Next</span>
						  </a>
	 				 @endif
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
	            </div>
	        </div>
	    </div>
	</div>
	<div id="myCarousel_{{$report->id}}" class="carousel slide" data-ride="carousel">

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner">
	  	@foreach ($report->imageEvidence() as $evidence)
			<div class="item {{ $loop->first ? 'active' : ' '}}">
		      <img src="{{ asset('evidence/'.$report->id.'/'.$evidence->multimedia_path) }}" alt="$evidence->multimedia_path" data-toggle="modal" data-target="#responsive-modal_{{$report->id}}">
		    </div>
		@endforeach
	  </div>

	  @if (count($report->imageEvidence()) > 1)
		  <!-- Left and right controls -->
		  <a class="left carousel-control" href="#myCarousel_{{$report->id}}" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel_{{$report->id}}" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		    <span class="sr-only">Next</span>
		  </a>
	  @endif
	</div>
@endif