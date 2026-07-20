<div class="modal fade" tabindex="-1" id="modalDelete_{{ $values->id }}">    
	<div class="modal-dialog modal-dialog-centered" role="document">        
		<div class="modal-content modal-sm"> 
			<a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">                
				<em class="icon ni ni-cross"></em>            
			</a>
			<div class="modal-body" style="text-align: center;">
				<div class="swal2-header">
					<i class="menu-icon tf-icons bx bx-error-circle" style="font-size: 75px;"></i>
					<div class="swal2-icon swal2-info" style="display: none;"></div>
					<div class="swal2-icon swal2-success" style="display: none;"></div>
					<img class="swal2-image" style="display: none;">
					<h2 class="swal2-title" id="swal2-title" style="display: flex;justify-content: center;">Are you sure?</h2>
					<button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
				</div>      
				<p>You want to delete this data ?</p>
				<div class="swal2-actions">
					<a href="{{ URL::to('delete-user/'.$values->id) }}" type="button" class="btn btn-success" aria-label="" style="display: inline-block; border-left-color: rgb(30, 224, 172) !important; border-right-color: rgb(30, 224, 172) !important;">Yes, delete it!</a>
					<a href="#" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</a>
				</div>            
			</div>   
		</div>    
	</div>
</div>