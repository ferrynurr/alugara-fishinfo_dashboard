                
<div class="table-responsive" style="padding: 10px;" id="tab_pivot">

  <div class="btn-group">
    <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Action <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
       <li><a onclick="pdf_export('pivot_konsumikan', 'Pivot <?= $title ?>')">Download PDF</a></li> 
       <li><a href="#">Save to dashboard</a></li>
    </ul>
  </div>
  <div class="row"><br>
    <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="form-group">
          <label class="control-label ">Pengukuran</label>
          <select style="width: 100%;" class="select2" multiple="True" id="pivot_field" name="pivot_field">
            <?php 
              foreach ($list_field->result() as $row)
              {
                if ($row->data_type=='number')  
                  echo '<option value="'.$row->field."|".$row->label.'"> '.$row->label.' </option>';
              } ?>
            <option value="count|Jumlah Data" selected>Jumlah Data</option>
          </select>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="form-group">
          <label class="control-label ">Baris</label>
          <select style="width: 100%;" class="select2" multiple="True" id="pivot_baris" name="pivot_baris">
            <!-- <option value="" selected></option> -->
            <?php 
              foreach ($list_field->result() as $row)
              {
                if ($row->data_type=='text')
                  echo '<option value="'.$row->field.'"> '.$row->label.' </option>';
              } ?>
          </select>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="form-group">
          <label class="control-label ">Operator</label>
          <select style="width: 100%;" class="select2" id="pivot_oper" name="pivot_oper">
            <option value="sum" selected>Sum</option>
            <option value="avg" >Avg</option>
          </select>
        </div>
    </div>
  </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <table id="pivot_konsumikan" class="table table-bordered" width="100%">
            <thead>
            </thead>
            <tbody>                   
            </tbody>
          </table>
        </div>
      </div>
</div>

<script type="text/javascript">

 $(document).ready(function() {
    get_pivot();
 });

function savetoPivoteDash(tbl)
{
    var thArray = [];

    $('#'+tbl+' > thead > tr > th').each(function(){
        thArray.push($(this).text());
    });

   var tbody = [];

    $('#'+tbl+' > tbody > tr').each(function(){
      tbody.push([$(this).text()]);
    });

    $('#pivot_konsumikan tr').each(function() {
      
      //tbody.push($(this).find("td:first").text());    
    });

var myRows = [];
var $headers = $("th");
var $rows = $("#pivot_konsumikan > tbody > tr").each(function(index) {
  $cells = $(this).find("td");
  myRows[index] = {};
  $cells.each(function(cellIndex) {
    myRows[index][$($headers[cellIndex]).text()] = $(this).text();
  });    
});
var myObj = {};
myObj.myrows = myRows;
alert(JSON.stringify(myObj));

}

  $("select").on("select2:select", function (evt) {
    var element = evt.params.data.element;
    var $element = $(element);
    
    $element.detach();
    $(this).append($element);
    $(this).trigger("change");
  });

  $('#pivot_field').on('change', function (e) {
    get_pivot();
  });

  $('#pivot_oper').on('change', function (e) {
    get_pivot();
  });

  $('#pivot_baris').on('change', function (e) {
    get_pivot();


  });

  function get_pivot()
  {
    var pivbar = $('#pivot_baris').val();
    var pivfieraw = $('#pivot_field').val();
    var pivopr = $('#pivot_oper').val();
    var pivfieval = [];
    var pivfietext = [];
    var headtot = [];
    var headcount = 0;

    for (var j=0; j<pivfieraw.length;j++){ 
      var buff = pivfieraw[j].split("|");
      pivfieval.push(buff[0]);
      pivfietext.push(buff[1]);
      headtot.push(0);
      // headcount.push(0);
    }

    var formData = {
      'pengukuran': pivfieval,
      'baris': pivbar,
      'operator': pivopr,
      'filter_all': $('#filter_all').val(),
    };
    var pivotTbl = document.getElementById('pivot_konsumikan');

    // alert ("5");

    $.ajax({
      url : "<?= base_url('Konsumsi_ikan/ajax_pivot_get')?>",
      type: "POST",
      data: formData,
      dataType: "json",
      success: function(data)
      {
        // alert(JSON.stringify(data));
        // alert ("10");
        for (var i = 0; i < pivotTbl.rows.length; i++) {
          $(pivotTbl).find('thead tr').remove();
          $(pivotTbl).find('tbody tr').remove();
        }

         //alert ("20");
        var has_total=0;var bhtml="";var hhtml="";
        // Header
        hhtml += "<tr><th class='text-center'>&nbsp;</th>";
        for (var j=0; j<pivfieval.length;j++){ 
          hhtml += "<th class='text-center' >"+pivfietext[j]+"</th>";
        }
        hhtml +="</tr>";

        // Body
        var barbuff = [];
        for (var i = 0; i<data.length; i++) {
          headcount += Number(data[i].count);
          if (pivbar)
          { 
          // jika pakai filter baris
            var ctr=0; var spacer ="";
            for (var j=0; j<pivbar.length; j++) 
            {
              ctr +=1;
              // make spacer
              for (var h=0;h<ctr-1;h++){
                spacer +="&nbsp;&nbsp;&nbsp;&nbsp;";
              }
              // pengolahan body
              bhtml += "<tr>";
              if (data[i][pivbar[j]])
              {
                // bhtml+="<td class='text-center'>kosong</td>"; bhtml+="<td class='text-center'>kosong</td>";
                // pengecekan dobel parent
                if (barbuff.length<=j)
                  barbuff.push(data[i][pivbar[j]]);
                else {
                  if (barbuff[j]==data[i][pivbar[j]] && ctr!=pivbar.length)
                    continue;
                  else 
                    barbuff[j]=data[i][pivbar[j]];
                }
                console.log(barbuff);
                // lolos cek
                bhtml += "<td class='text-left'>"+spacer+data[i][pivbar[j]]+"</td>";
                for (var k=0; k<pivfieval.length;k++){ 
                  if (ctr==pivbar.length){
                    if (data[i][pivbar[j]]){
                      bhtml+="<td class='text-center'>"+Number(data[i][pivfieval[k]]).toFixed(2)+"</td>";
                    }
                    if (pivopr=='sum')
                      headtot[k] =(Number(headtot[k])+ Number(data[i][pivfieval[k]])).toFixed(2);
                    if (pivopr=='avg')
                      headtot[k] =((Number(headtot[k])+ Number(data[i][pivfieval[k]]))*Number(data[i]['count'])).toFixed(2);
                    
                  }
                  else {
                    if (data[i][pivbar[j]]){
                      bhtml+="<td class='text-center'>&nbsp;</td>";
                    }                    
                  }

                }
              }
             
              bhtml +="</tr>";

            }

          }
          else { // jika tanpa baris
            bhtml += "<tr>";
            if (data[i][pivbar]){
              bhtml += "<td class='text-center'>"+data[i][pivbar]+"</td>";
            }
            for (var k=0; k<pivfieval.length;k++){ 
              if (data[i][pivbar]){
                bhtml+="<td class='text-center'>"+Number(data[i][pivfieval[k]]).toFixed(2)+"</td>";
              }
              headtot[k] =(Number(headtot[k])+ Number(data[i][pivfieval[k]])).toFixed(2);
            }

            bhtml +="</tr>";
          }
        }
        bhtml += "<tr><td class='text-center' style='font-size:12px;'><b>TOTAL</b></td>";
        for (var j=0;j<headtot.length;j++){
          console.log(headcount);
            if (pivopr=='sum')
              bhtml += "<td class='text-center'><b>"+headtot[j]+"</b></td>";
            if (pivopr=='avg')

            if (pivbar)
              bhtml += "<td class='text-center'><b>"+(Number(headtot[j])/Number(headcount)).toFixed(2)+"</b></td>";
            else
              bhtml += "<td class='text-center'><b>"+(Number(headtot[j]))+"</b></td>";          
        }
        bhtml += "</tr>";
        $(pivotTbl).find('thead').append(hhtml);
        $(pivotTbl).find('tbody').append(bhtml);
       // alert ("30");
      },
      error: function (request, textStatus, errorThrown)
      {
          // alert('Error getting data');

        alert(request.responseText);
          Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Failed',
              showConfirmButton: false,
              timer: 1600
          })
      
      }
    });   
  }
</script>