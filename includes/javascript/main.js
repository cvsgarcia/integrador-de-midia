function toggleData(element)
{
	
	var inputData = element.value;
	
	if ( element.checked )
	{
		console.log(true);
		$(' .data-' +inputData).show();
	}
	else
	{
    	$(' .data-' +inputData).hide();
    }
}

$( document ).ready(function() {
    $('input:checkbox').each(function()
	{
		var inputData = $(this).val();
			
			if ( this.checked )
			{
				console.log(true);
				$(' .data-' +inputData).show();
			}
			else
			{
		    	$(' .data-' +inputData).hide();
		    }
	})

});