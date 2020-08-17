                
<div class="table-responsive" style="padding: 10px;" id="tab_pivot">

        <div class="btn-group">
          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Action <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
             <li><a onclick="pdf_export('pivot_harga_nonkonsumsi', 'Pivot <?= $title ?>')">Download PDF pv</a></li> 
             <li><a href="#" id="btn-savegraph">Save to dashboard</a></li>
          </ul>
        </div>

  <div class="row">
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
   <figure class="highcharts-figure">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" id="panel_pivot">
          <table id="pivot_harga_konsumsi" class="table table-bordered" width="100%">
            <thead>
            </thead>
            <tbody>                   
            </tbody>
          </table>
        </div>
      </div>
    </figure>
</div>

<script type="text/javascript">

 $(document).ready(function() {
    get_pivot();
 });

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
    var pivotTbl = document.getElementById('pivot_harga_konsumsi');

    // alert ("5");

    $.ajax({
      url : "<?= base_url('non_konsumsi/ajax_pivot_get')?>",
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
        hhtml += "<tr><th class='text-center' style='vertical-align: middle;'</th>";
        for (var j=0; j<pivfieval.length;j++){ 
          hhtml += "<th class='text-center' >"+pivfietext[j]+"</th>";
        }
        hhtml +="</tr>";

        // Body
        var barbuff = [];
        for (var i = 0; i<data.length; i++) {
          headcount += Number(data[i].count);
          if (pivbar){ // jika pakai filter baris
            var ctr=0; var spacer ="";
            for (var j=0; j<pivbar.length; j++) {
              ctr +=1;
              // make spacer
              for (var h=0;h<ctr-1;h++){
                spacer +="&nbsp;&nbsp;&nbsp;&nbsp;";
              }
              // pengolahan body
              bhtml += "<tr>";
              if (data[i][pivbar[j]]){
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
                      bhtml+="<td class='text-center'></td>";
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
        hhtml += "<tr><th class='text-left'><strong>Total</strong></th>";
        for (var j=0;j<headtot.length;j++){
          console.log(headcount);
            if (pivopr=='sum')
              hhtml += "<th class='text-center'><strong>"+headtot[j]+"</strong></th>";
            if (pivopr=='avg')
              if (pivbar)
                hhtml += "<th class='text-center'><strong>"+(Number(headtot[j])/Number(headcount)).toFixed(2)+"</strong></th>";
              else
                hhtml += "<th class='text-center'><strong>"+(Number(headtot[j]))+"</strong></th>";          
        }
        hhtml += "</tr>";
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