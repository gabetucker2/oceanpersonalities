function PostFromJS(path, parameters)//creates a form and input at the bottom of the page to submit it as a POST from JS
{
	let form = document.createElement("form");
	form.method = "POST";
	form.action = path;
	
	if(parameters != null)
	{
		for(let key in parameters)
		{
			let hiddenField = document.createElement("input");
			hiddenField.type = "hidden";
			hiddenField.name = key;
			hiddenField.value = parameters[key];
			
			form.appendChild(hiddenField);
		}
	}
	
	document.body.appendChild(form);
	form.submit();
}
