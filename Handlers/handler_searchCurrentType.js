function SearchCurrentType(OTIType, questionResponses)//QR = null for none
{
	PostFromJS("./typeDefine.php?OTIType=" + OTIType, questionResponses);
}

function SubmitTypeForm()
{
	let OTIType = "";
	
	traitWords.forEach(typeWord =>
	{
		let typeVals = document.getElementsByName(typeWord);
		let currentTypeVal = -1;
		
		for(let i = 0; i < typeVals.length; i++)//goes through each segment
		{						
			if(typeVals[i].checked)//checks if each radio was checked
			{
				currentTypeVal = i;//if the current typeVal in the segment is checked then set to number to reference when setting typePath
				
				break;
			}
		}
		
		if(currentTypeVal != -1)
		{
			OTIType += (currentTypeVal + 1);//e.g. typePath = "?currentType=32312" for GET method after arriving on next page
		}
	})
	
	if(OTIType.length == 5)
	{
		PostFromJS("./typeDefine.php?OTIType=" + OTIType, null);
	}
}
