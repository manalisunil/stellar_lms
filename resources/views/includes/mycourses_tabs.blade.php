<div class="row pl-4">
	<div class="flex justify-content-center">
		<div class="card">
			<div class="card-body tabborder" >
				<table width="100% " class="ml-1">
					<tr>
						@forelse($cources as $cour)
							<td><a id="tab1" class="btn btn-sm  odtabs {{($cour->id == $course_id) ? 'btn-secondary' :'btn-outline-secondary'}}"  href="{{route('course_detail',$cour->id)}}" >{{$cour->course_name}}</a></td>
						@empty
						@endforelse
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>