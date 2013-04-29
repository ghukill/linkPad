function runLinksAction(){
    // link adding
    if (linksAction == "linksAdd"){
        $("#linksManage").append("<h1 class='text-success'>Link Added:</h1><p><strong>Title:</strong> "+linkObject.Title+"</br><strong>URL:</strong> <a href='"+linkObject.URL+"'>"+linkObject.URL+"</a></p>");
        $("#linksManage").fadeToggle();
    }
    // link purging
    else if (linksAction == "linksPurge"){
        $("#linksManage").append("<h1 class='text-error'>All Links Purged.  I hope this was intentional.</h1>");
        $("#linksManage").fadeToggle();
    }
    // link showing
    else {
        showLinks();
    }

}

function showLinks(){    

    dataObject = new Object();
    //get values from form
    dataObject.GETparams = new Object();
    dataObject.core = "linkPad"
    dataObject.GETparams.q = "*:*";
    // dataObject.GETparams.fq = $('#fq').val();
    // dataObject.GETparams.fl = $('#fl').val();
    dataObject.GETparams.start = "0";
    dataObject.GETparams.rows = "100";
    dataObject.GETparams.wt = "json"; //sets response to JSON    
    //datatype, request
    dataObject.data_type = "unfiltered"; //json expected, unfiltered
    dataObject.request_type = "GET";
    //assemble URL
    dataObject.baseURL = "http://localhost:8983/solr/"+dataObject.core+"/select?";        
    
    $(document).ready(function(){
      $.ajax({
        type: "POST",
        url: "php/ajax_tunnel_v2.php",
        data: dataObject,
        dataType: "json",
        success: SolrSuccess,
        error: SolrError
      });
    });

    function SolrSuccess(response){
        // console.log(response);
        var links = response;
        
        if (links.response.docs.length > 0){
            for (var i = 0; i < links.response.docs.length; ++i){
                linkDoc = links.response.docs[i];                
                $("#links").append("<li>"+(i+1)+") <a target='_blank' href='"+linkDoc.linkURL+"'>"+linkDoc.linkTitle+"</a></li>");
            }
        }

        else{
            $("#links").append("<li>Yarrrggggh, thar be nothing here, the seas creek quiet.</li>");
        }

        $("#linksShow").fadeToggle();

    }

    function SolrError(response){
        console.log('no dice');
    }
}