/*Makes an Ajax GET request to the request_handler and passess the request_id to
the handler through the 'request' parameter. 
Example of using this function:
makeAjaxGetRequest('main.php','cmd_load_homepage', '&key=value', success);
success - is a developer defined callback function which is called when the request has returned.
*/
function makeAjaxGetRequest(request_handler, requestid, params, success) {
    var xhttp;    
    xhttp = new XMLHttpRequest();
    if (params == null)   
    {
        xhttp.open("GET", request_handler + "?request=" + requestid, true);
    } 
    else 
    {
        xhttp.open("GET", request_handler + "?request=" + requestid + params, true);
    }
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            if (success == null)
            {
                return this.responseText;
            }
            else
            {
                success(this.responseText);
            }
        }
    };        
    xhttp.send();            
}

/*Makes an Ajax POST request to the request_handler and passess the request_id to
the handler through the 'request' parameter. 
Example of using this function:
makeAjaxPostRequest('main.php','cmd_load_homepage', '&key=value', success);
success - is a developer defined callback function which is called when the request has returned.
*/
function makeAjaxPostRequest(request_handler, requestid, params, success) {
    var xhttp;    
    xhttp = new XMLHttpRequest();
    xhttp.open("POST", request_handler, true);    
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            if (success == null)
            {
                return this.responseText;
            }
            else
            {
                success(this.responseText);
            }
        }
    };
    if (params == null) 
    {
        xhttp.send("request=" + requestid);        
    } 
    else 
    {        
        if (params instanceof FormData) 
        {
            //params is an instance of formdata appended to the requestid before sending           
            params.append('request', requestid);
            xhttp.send(params);
        } 
        else 
        {
            //xhttp.setRequestHeader("Content-type", "multipart/form-data"); //for sending binary
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //simple string params
            xhttp.send("request=" + requestid + params);
        }
    }
}
