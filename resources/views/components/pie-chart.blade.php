<div>
	<div class="card">
		<div class="card-header">
			<h4>{{ $chartTitle }}</h4>
		</div>
		<div class="card-body">
			<div id="{{ $chartID }}"></div>
		</div>
	</div>
</div>

@push('js')
<script>
	$(function() {
  	const chartID = "#{{ $chartID }}";
  	const categories = @json($categories);
  	const series = @json($series);

  	let options = {
  		series: series,
  		chart: {
  			height: 300,
  			type: "pie",
  		},
  		labels: categories,
  		responsive: [
  			{
  				breakpoint: 480,
  				options: {
  					chart: {
  						width: 200,
  					},
  					legend: {
  						position: "bottom",
  					},
  				},
  			},
  		],
  	};

  	@isset($colors)
  		options.colors = @json($colors)
  	@endisset

  	new ApexCharts(document.querySelector(chartID), options).render();
  });
</script>
@endpush
