<script src="{{ url('adminlte/js') }}/jquery-1.11.3.min.js"></script>
<script src="{{ url('adminlte/js') }}/jquery.dataTables.min.js"></script>
<script src="{{ url('adminlte/js') }}/dataTables.buttons.min.js"></script>
<script src="{{ url('adminlte/js') }}/buttons.flash.min.js"></script>
<script src="{{ url('adminlte/js') }}/jszip.min.js"></script>
<script src="{{ url('adminlte/js') }}/pdfmake.min.js"></script>
<script src="{{ url('adminlte/js') }}/vfs_fonts.js"></script>
<script src="{{ url('adminlte/js') }}/buttons.html5.min.js"></script>
<script src="{{ url('adminlte/js') }}/buttons.print.min.js"></script>
<script src="{{ url('adminlte/js') }}/buttons.colVis.min.js"></script>
<script src="{{ url('adminlte/js') }}/dataTables.select.min.js"></script>
<script src="{{ url('adminlte/js') }}/jquery-ui.min.js"></script>
<script src="{{ url('adminlte/js') }}/bootstrap.min.js"></script>
<script src="{{ url('adminlte/js') }}/select2.full.min.js"></script>
<script src="{{ url('adminlte/js') }}/main.js"></script>
<script src="{{ url('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ url('adminlte/js/app.min.js') }}"></script>

<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>
	$(document).ready(function() {
		CKEDITOR.replaceClass = 'ckeditor';
	});
</script>

<script>
	$(document).ready(function() {
		@if(!empty(auth()->user()) && auth()->user()->role_id==3)
		//alert("here");
		window.location.href = "{{route('home')}}";
		@endif
	});
</script>

<script>
		window._token = '{{ csrf_token() }}';
		$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});
		$('#type').change(function(){
			var type=$(this).val();
			if(type==1)
			{
				$('#lession').hide();
			}else{
				$('#lession').show();
			}
		})
		$('#courseId').change(function(){
			var courseId=$(this).val();
			$.ajax({
				type:'POST',
				url:'<?php echo url('/') ?>/admin/lession/getcourselession',
				data:{_token: "{{ csrf_token() }}",courseId:courseId},
				success: function( response ) {
					$('#lessionId').html(response);
				}
			});
		});
		$('#lessionId').change(function(){
			var lessionId=$(this).val();
			$.ajax({
				type:'POST',
				url:'<?php echo url('/') ?>/admin/lession/getlessiontopic',
				data:{_token: "{{ csrf_token() }}",lessionId:lessionId},
				success: function( response ) {
					$('#topicId').html(response);
				}
			});
		});
		$("#addmoreQuiz").click(function(){
			var lt=$('body').find('.ll').length;
			console.log(lt);
			var ht='<div class="input-group ll"><div class="form-group"><label for="question">Quiz Question '+lt+'</label><input type="text" name="question[]" class="form-control" placeholder="Enter a Question?" required></div><div class="form-group"><label for="image">Quiz Question Image '+lt+'</label><input type="file" name="image[]" class="form-control" accept="image/*"></div><div class="form-group col-md-6"><label for="courseID">Option-1 <input type="radio" name="option_type" value="1" checked>Text <input type="radio" name="option_type"  value="0">Image </label><div class="text_1_'+lt+'"><input type="text" name="option['+lt+'][]" class="form-control"></div></div><div class="form-group col-md-6"><label for="courseID">Option-2 <input type="radio" name="option_type" value="1" checked>Text <input type="radio" name="option_type" value="0">Image </label><div class="text_2_'+lt+'"><input type="text" name="option['+lt+'][]" class="form-control"></div></div><div class="form-group col-md-6"><label for="courseID">Option-3 <input type="radio" name="option_type" value="1" checked>Text <input type="radio" name="option_type" value="0">Image </label><div class="text_3_'+lt+'"><input type="text" name="option['+lt+'][]" class="form-control"></div></div><div class="form-group col-md-6"><label for="courseID">Option-4 <input type="radio" name="option_type" value="1" checked>Text <input type="radio" name="option_type" value="0">Image </label><div class="text_4_'+lt+'"><input type="text" name="option['+lt+'][]" class="form-control"></div></div><div class="form-group"><label for="Currectoption">Currect option</label><br><label><input type="radio" name="Currectoption['+lt+'][]" value="1" checked> Option-1 </label><label><input type="radio" name="Currectoption['+lt+'][]" value="2"> Option-2 </label><label><input type="radio" name="Currectoption['+lt+'][]" value="3"> Option-3 </label><label><input type="radio" name="Currectoption['+lt+'][]" value="4"> Option-4 </label></div><div class="form-group"><label for="marks">Marks</label><input type="number" name="marks[]" class="form-control" required></div><div class="form-group"><label for="solution">Solution</label><textarea name="solution[]" class="form-control" required></textarea></div><div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-danger removefaq"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></div></div>';
			
			$('#addmQUiz').append(ht);
			
		});
		$("#addbtnfaq").click(function(){
			var ht='<div class="input-group"><div class="form-group"><label for="courseID">Title</label><input required class="form-control" type="text" name="faqTitle[]"></div><div class="form-group"><label for="courseID">Contant</label><textarea name="faqcontant[]" class="form-control" placeholder="Contant" required></textarea></div><div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-danger removefaq"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></div></div>';
			
			$('#addfaq').append(ht);
			
		});
		$("#addftbtn").click(function(){
			var ht='<div class="input-group"><div class="form-group"><label for="courseID">Features</label><input required class="form-control" type="text" name="featu[]"></div><div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-danger removefat"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></div></div>';
			
			$('#addfet').append(ht);
								
		});
		$("#addbtnfact").click(function(){
			var ht='<div class="input-group"><div class="form-group"><label for="icon">Icon</label><input type="file" name="fact_icon[]" class="form-control"></div><div class="form-group"><label for="title">Title</label><input type="text" name="fact_title[]" class="form-control" placeholder="Title"></div><div class="form-group"><label for="subtitle">Subtitle</label><input type="text" name="fact_sub_title[]" class="form-control" placeholder="Subtitle"></div><div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-danger removefact"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></div></div>';
			
			$('#addfact').append(ht);
			
		});
		$("#addbtnpricingfaq").click(function(){
			var ht='<div class="input-group"><div class="form-group"><label for="question">Question</label><input type="text" name="question[]" class="form-control" placeholder="Question"></div><div class="form-group"><label for="answer">Answer</label><textarea name="answer[]" class="form-control" placeholder="Answer"></textarea></div><div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-danger removepricingfaq"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></div></div>';
			
			$('#addpricingfaq').append(ht);
			
		});
	
		//remove fields group
		$("body").on("click",".removefat",function(){ 
			$(this).parents(".input-group").remove();
		});
		$("body").on("click",".removefaq",function(){ 
			var id=$(this).attr('title');
			if(confirm("Are you sure?"))
			{
				$(this).parents(".input-group").remove();
				$.ajax({
					type:'POST',
					url:'<?php echo url('/') ?>/admin/quizs/deleteOption',
					data:{_token: "{{ csrf_token() }}",id:id},
					success: function( response ) {
						//$('#lessionId').html(response);
					}
				});
			}
					 
		});
	
		//remove fields group
		$("body").on("click",".removefact",function(){ 
			$(this).parents(".input-group").remove();
		});
	
		//remove fields group pricing faq
		$("body").on("click",".removepricingfaq",function(){ 
			$(this).parents(".input-group").remove();
		});
		
		$(document).on('change', 'input[name="option_type"]', function() {
			//alert();
			if( $(this).is(":checked") ){ // check if the radio is checked
				var val = $(this).val(); // retrieve the value
			}
			if(val==0){
				$(this).closest('div').children('div').find('input').attr('type','file');
			}else{
				$(this).closest('div').children('div').find('input').attr('type','text');
			}
		});

		$(".toggle-password").click(function() {
			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle"));
			if (input.attr("type") == "password") {
				input.attr("type", "text");
			} else {
				input.attr("type", "password");
			}
		});


		$('.generateCode').click(function(){
			var lessionId=$(this).val();
			$.ajax({
				type:'POST',
				url:'<?php echo url('/') ?>/admin/couponcodes/getcouponcode',
				data:{_token: "{{ csrf_token() }}",lessionId:lessionId},
				success: function( response ) {
					$('#coupon').val(response);
				}
			});
		});
		 
</script>
@yield('javascript')