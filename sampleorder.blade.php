@extends('layouts.master')

@section('content')

<style>

.progress {
  position: relative;
}

.progress-bar-title {
  position: absolute;
  text-align: center;
  line-height: 20px; /* line-height should be equal to bar height */
  overflow: hidden;
  color: #000000;
  right: 0;
  left: 0;
  top: 0;
}
</style>
<script type="text/javascript">
var source = 'edit';
// widget configuration
var config = { 
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'top', size: 110, html: 'top' },
            { type: 'main', minSize: 250, overflow: 'hidden' }
        ]
    },
    form: {
        header: '',
        name: 'form',
        style: 'border: 0px; background-color: transparent;',
        formHTML:
            '<div class="w2ui-page page-0">'+
            '     <div style="width: 380px; float: left; margin-right: 0px;">'+
            '          <div class="w2ui-field w2ui-span5">'+
            '              <label>Order No:</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="orderno" id="orderno" type="text" maxlength="100" style="width: 100%" readonly placeholder="Auto generated">'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span5">'+
            '              <label>Reference No:</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="reference" id="reference" type="text" maxlength="100" style="width: 100%">'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span5">'+
            '              <label>Customer :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="customerid" id="customerid" type="text" maxlength="100" style="width: 100%" onchange="">'+
            '              </div>'+
            '          </div>'+
            '  </div>'+
            '  <div style="width: 375px; float: right; margin-left: 0px;">'+
            '          <div class="w2ui-field w2ui-span4">'+
            '              <label>Order Date :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="orderdate" id="orderdate" class="datepicker" type="date"  maxlength="100" style="width: 100%" readonly>'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span4">'+
            '              <label>Status :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="status" id="status" type="text" maxlength="100" style="width: 100%" readonly>'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span4">'+
            '              <label>HCP :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="doctorid" id="doctorid" type="text" maxlength="100" style="width: 100%" onchange=";">'+
            '              </div>'+
            '          </div>'+
            '  </div>'+
            '</div>',
        fields: [
            { field: 'reference', type: 'text'},
            { field: 'orderno', type: 'text'},
            { field: 'orderdate', type: 'text'},
            { field: 'enddate', type: 'text'},
            { field: 'productid', type: 'list',
                options: { items: <?php echo $skuoptionlist; ?> }
            },
            { field: 'doctorid', type: 'list',
                options: { items: <?php echo $doctoroptionlist; ?> ,match: 'contains',markSearch: true,}
            },
            { field: 'customerid', type: 'list',
                options: { items: <?php echo $customeroptionlist; ?> ,match: 'contains',markSearch: true,}
            },
            { field: 'status', type: 'list',
                options: { items: <?php echo $statuslist; ?> }
            },
        ],
        onChange: function (event) {
		if(event['target']=='doctorid'){
		        $("#sku").attr("readonly", false);
                //$("#skuqty").attr("readonly", false);
                hcparray = $('#doctorid').val().split(' - ');
                $('#remark').val('Attention to ' + hcparray[1] + '(' + hcparray[0] + ')') ;
                w2ui['form2'].record['remark'] = 'Attention to ' + hcparray[1] + '(' + hcparray[0] + ')';

                var formData = {
                  _token: "{{ csrf_token() }}",
                  skulist : $( "#productlist" ).val(),
                  qtylist : $( "#qtylist" ).val(),
                    batchnolist : $( "#batchnolist" ).val(),
                  orderno : w2ui['form'].record['orderno'],
                  doctorid : event['value_new']['id']
                };
                $.ajax({
                    type: 'POST',
                    url: '/getskulist2',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        w2ui['grid1'].clear();
                        w2ui['grid1'].add(data.query);
                        w2ui['grid2'].clear();
                        w2ui['grid2'].add(data.query);
                        $("#sku").attr("readonly", false);
                        //$("#skuqty").attr("readonly", false);
                },
                    error: function (data) {
                        w2alert('Error.');
                    }
                });
            }
        
        }
    }
};
var configdisable = { 
    form: {
        header: '',
        name: 'form',
        style: 'border: 0px; background-color: transparent;',
        formHTML:
            '<div class="w2ui-page page-0">'+
            '     <div style="width: 380px; float: left; margin-right: 0px;">'+
            '          <div class="w2ui-field w2ui-span5">'+
            '              <label>Order No:</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="orderno" id="orderno" type="text" maxlength="100" style="width: 100%" readonly placeholder="Auto generated">'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span5">'+
            '              <label>Reference No:</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="reference" id="reference" type="text" maxlength="100" readonly style="width: 100%">'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span5">'+
            '              <label>Customer :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="customerid" id="customerid" type="text" maxlength="100" readonly style="width: 100%" onchange="alert(1);">'+
            '              </div>'+
            '          </div>'+
            '  </div>'+
            '  <div style="width: 375px; float: right; margin-left: 0px;">'+
            '          <div class="w2ui-field w2ui-span4">'+
            '              <label>Order Date :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="orderdate" id="orderdate" class="datepicker" type="date"  maxlength="100" readonly style="width: 100%" readonly>'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span4">'+
            '              <label>Status :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="status" id="status" type="text" maxlength="100" style="width: 100%" readonly>'+
            '              </div>'+
            '          </div>'+
            '          <div class="w2ui-field w2ui-span4">'+
            '              <label>HCP :</label>'+
            '              <div>'+
            '                  <input class="w2ui-input" name="doctorid" id="doctorid" type="text" maxlength="100" readonly style="width: 100%" onchange="alert(2);">'+
            '              </div>'+
            '          </div>'+
            '  </div>'+
            '</div>',
        fields: [
            { field: 'reference', type: 'text'},
            { field: 'orderno', type: 'text'},
            { field: 'orderdate', type: 'text'},
            { field: 'enddate', type: 'text'},
            { field: 'productid', type: 'list',
                options: { items: <?php echo $skuoptionlist; ?> }
            },
            { field: 'doctorid', type: 'list',
                options: { items: <?php echo $doctoroptionlist; ?> ,match: 'contains',markSearch: true,}
            },
            { field: 'customerid', type: 'list',
                options: { items: <?php echo $customeroptionlist; ?> ,match: 'contains',markSearch: true,}
            },
            { field: 'status', type: 'list',
                options: { items: <?php echo $statuslist; ?> }
            },
        ],
    }
};
function addsku(){
        var value = $('#sku').val();
    	var skuqty = $('#skuqty').val();
        var skuqtyrate = $('#skuqty').val()*$('#productrate').val();
    	var batchno = $('#batchno').val();
        var productbatchno = $('#skulist [value="' + value + '"]').data('value') + "_" + $('#batchno').val();
    	
        if(!value){
            w2alert('Please select sku');
            return false;
        }
        if(!skuqty){
            w2alert('Please enter qty');
            return false;
        }
        /*if(!batchno){
            w2alert('Please enter batchno');
            return false;
}*/
        test = $( "#productlist" ).val();
        test1 = $( "#qtylist" ).val();
	    test11 = $( "#batchnolist" ).val();
        testproductbatchno = $( "#productbatchnolist" ).val();

        if(parseInt(skuqtyrate) > parseInt($('#balqty').val())){
            w2alert('Quota reached');
            return false;
        }

        skulist = $( "#productlist" ).val().replace(/['"]+/g, '');
        skuarray = skulist.split(',');
        pbatchnolist = $( "#productbatchnolist" ).val().replace(/['"]+/g, '');
        productbatchnoarray = pbatchnolist.split(',');
        productid = $('#skulist [value="' + value + '"]').data('value');
        //if(skuarray.map(Number).includes(productid)){
        if(productbatchnoarray.includes(productbatchno)){
            let index = skuarray.map(Number).indexOf(productid);
        }else{
            var str1 = test;
            var str2 = "'" + $('#skulist [value="' + value + '"]').data('value')+"'";
            var str111 = testproductbatchno;
            var str222 = "'" + $('#skulist [value="' + value + '"]').data('value')+"'";

            var str11 = test1;
            var str22 = "'" + skuqty +"'";
            //if(str1.indexOf(str2) == -1){
            if(str111.indexOf(str222) == -1){
              if(test != ""){
                test2 = test + ",'" + $('#skulist [value="' + value + '"]').data('value')+"'";
                test22 = test1 + ",'" + skuqty +"'";
                test222 = testproductbatchno + ",'" + productbatchno +"'";
                test2222 = test11 + ",'" + batchno +"'";
              }else{
                test2 = "'" + $('#skulist [value="' + value + '"]').data('value')+"'";
                test22 = "'" + skuqty +"'";
                test222 = "'" + productbatchno +"'";
                test2222 = "'" + batchno +"'";
              }
            }
            /*var str11 = test1;
            var str22 = "'" + skuqty +"'";
            if(str11.indexOf(str22) == -1){
              if(test1 != ""){
                test22 = test1 + ",'" + skuqty +"'";
              }else{
                test22 = "'" + skuqty +"'";
              }
            }*/
        }
         
        $( "#productbatchnolist" ).val(test222);
        $( "#batchnolist" ).val(test2222);
        $( "#productlist" ).val(test2);
        $( "#qtylist" ).val(test22);
        $('#sku').val('');
        var formData = {
          _token: "{{ csrf_token() }}",
          skulist : $( "#productlist" ).val(),
          qtylist : $( "#qtylist" ).val(),
          batchnolist : $( "#batchnolist" ).val(),
          orderno : w2ui['form'].record['orderno'],
          doctorid : w2ui['form'].record['doctorid']['id']
        };
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: '/getskulist2',
            data: formData,
            dataType: 'json',
            success: function (data) {
                w2ui['grid1'].clear();
                w2ui['grid1'].add(data.query);
                console.log(data);
                w2ui['grid2'].clear();
                w2ui['grid2'].add(data.query);
	    	$("#sku").attr("readonly", false);
                //$("#skuqty").attr("readonly", false);
	    },
            error: function (data) {
                w2alert('Error.');
            }
        });
        //w2ui['grid1'].clear();
        //w2ui['grid1'].add($( "#productlistjson" ).val());
        //alert($('#skulist [value="' + value + '"]').data('value'));
}
function deletesku(productid,batchno){
        if (batchno === undefined) {
            batchno = ''; 
        }
        skulist = $( "#productlist" ).val().replace(/['"]+/g, '');
        qtylist = $( "#qtylist" ).val().replace(/['"]+/g, '');
        batchnolist = $( "#batchnolist" ).val().replace(/['"]+/g, '');
        productbatchnolist = $( "#productbatchnolist" ).val().replace(/['"]+/g, '');
        skuarray = skulist.split(',');
        qtyarray = qtylist.split(',');
        batchnoarray = batchnolist.split(',');
        productbatchnoarray = productbatchnolist.split(',');
        index = productbatchnoarray.indexOf(productid+'_'+batchno);
        console.log(productbatchnoarray);
        console.log(productid+'_'+batchno);
        console.log(index); 
        console.log(skuarray);
        //index = skuarray.indexOf(productid);
        qtyarray.splice(index, 1);
        skuarray.splice(index, 1);
        console.log(skuarray);
        batchnoarray.splice(index, 1);
        productbatchnoarray.splice(index, 1);
        
        test2 = skuarray.join(",");
        test22 = qtyarray.join(",");
        test222 = batchnoarray.join(",");
        test2222 = productbatchnoarray.join(",");
        
        $( "#productlist" ).val(test2);
        $( "#qtylist" ).val(test22);
        $( "#batchnolist" ).val(test222);
        $( "#productbatchnolist" ).val(test2222);
        $('#sku').val('');
        $('#skuqty').val('');
        $('#batchno').val('');
        var formData = {
          _token: "{{ csrf_token() }}",
          skulist : $( "#productlist" ).val(),
          qtylist : $( "#qtylist" ).val(),
          batchnolist : $( "#batchnolist" ).val(),
          orderno : w2ui['form'].record['orderno'],
          doctorid : w2ui['form'].record['doctorid']['id']
        };

        $.ajax({
            type: 'POST',
            url: '/getskulist2',
            data: formData,
            dataType: 'json',
            success: function (data) {
                w2ui['grid1'].clear();
                w2ui['grid1'].add(data.query);
                w2ui['grid2'].clear();
                w2ui['grid2'].add(data.query);
                $("#sku").attr("readonly", false);
                //$("#skuqty").attr("readonly", false);
            },
            error: function (data) {
                w2alert('Error.');
            }
        });
        //w2ui['grid1'].clear();
        //w2ui['grid1'].add($( "#productlistjson" ).val());
        //alert($('#skulist [value="' + value + '"]').data('value'));
}
var config3 = {
    layout: {
        name: 'layout2',
        panels: [
            { type: 'top', minSize: 450, overflow: 'hidden' } ,
            { type: 'main', minSize: 50, overflow: 'hidden' }       ]
    },
    grid1: {
        name: 'grid1',
        show : {
          toolbar: false,
          footer: false,
          toolbarSearch: false,
          toolbarInput: false,
          toolbarReload: false,
        },
        toolbar: {
        style: 'height: 60px;',
        items: [
                { type: 'html',  id: 'item1',
                html: function (item) {
                    var html =
                      '<datalist id="skulist">'+
                      @foreach (json_decode($skuoptionlist) as $query)
                      '  <option data-value="{{ $query->id }}" value="{{ $query->text }}"></option>'+
                      @endforeach
                      '</datalist>'+
                      '<div style="padding: 3px 3px;margin-top:-5px;">'+
                        '<table style="border-spacing: 5px;border-collapse: separate;width:100%;">'+
                        '<tr>'+
                            '<td>Product</td>'+
                            '<td align="center">Qty</td>'+
                            '<td align="center">Use</td>'+
                            '<td></td>'+
                            '<td align="center">Balance</td>'+
                            '<td align="center" width="100px;">Unit</td>'+
                            '<td align="center">Batch No</td>'+
                            '<td></td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><input id="sku" name="sku"  oninput="onInput()" list="skulist" style="width: 300px" placeholder="Search product"  autocomplete="off" readonly></td>'+
                            '<td><input id="skuqty" style="width: 50px" type="number" onchange="updatechekqty(this.value);" placeholder="Qty" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" readonly></td>'+
                            '<td><input id="checkqty" style="width: 50px" placeholder="Qty" value="0" readonly></td>'+
                            '<td>/</td>'+
                            '<td><input id="balqty" style="width: 50px"  placeholder="Qty" value="0" readonly></td>'+
                            '<td><input id="uom" style="width: 50px" placeholder="Unit" value="" readonly></td>'+
                            '<td><input id="batchno" style="width: 100px" placeholder="Batch No" readonly></td>'+
                            '<td><button class="w2ui-btn" onclick="addsku();">Add</button></td>'+
                        '</tr>'+
                        '</table>'+
                      '</div>';
                    return html;
                    }
                },{ type: 'html',  id: 'item2',
                html: function (item) {
                    var html =
                      '<button class="w2ui-btn" onclick="addsku();">Add</button>';
                    return html;
                    }
                },
            ],
            onClick: function (target, data) {
                console.log(target);
            }
        },
        columns: [
            { field: 'Code', text: 'Code', size: '80px' },
            { field: 'product', text: 'Product', size: '100%' },
            { field: 'productgroup', text: 'Product Group', size: '100px' },
            { field: 'batchno', text: 'Batch No', size: '100px' },
            { field: 'qty', text: 'Qty', size: '50px' },
            { field: 'balqty', text: 'Available Qty', size: '100px' },
        ],
        records: [
        ]
    }
}


var config4 = {
    layout: {
        name: 'layout4',
        panels: [
            { type: 'top', minSize: 100, overflow: 'hidden' } ,
            { type: 'main', minSize: 250, overflow: 'hidden' }       ]
    },
    grid4: {
        name: 'grid4',
        header: 'History',
        show : {
          toolbar: false,
          footer: false,
          header: true,
          toolbarSearch: false,
          toolbarInput: false,
          toolbarReload: false,
        },
        columns: [
            { field: 'orderno', text: 'Order No', size: '100px' },
            { field: 'orderdate', text: 'Order Date', size: '100px' },
            { field: 'productcode', text: 'Code', size: '80px' },
            { field: 'productname', text: 'Product', size: '100%' },
            { field: 'productgroup', text: 'Product Group', size: '100px' },
            { field: 'batchno', text: 'Batch No', size: '80px' },
            { field: 'qty', text: 'Qty', size: '50px' },
        ],
        records: [
        ]
    }
}
var config2 = {
    layout: {
        name: 'layout2',
        panels: [
            { type: 'top', minSize: 250, overflow: 'hidden' },
            { type: 'main', minSize: 100, overflow: 'hidden' }
        ]
    },
    layout3: {
        name: 'layout3',
        panels: [
            { type: 'main', minSize: 550, overflow: 'hidden' }
        ]
    },
    form2: {
        name: 'form2',
        style: 'border: 1px solid #efefef',
        fields: [
            { field: 'remark', type: 'textarea',
                html: {
                    label: 'Instruction',
                    attr: 'style="width: 550px; height: 75px"'
                }
            }
        ]
    },
    grid1: {
        name: 'grid1',
        show : {
          toolbar: true,
          footer: false,
          toolbarSearch: false,
          toolbarInput: false,
          toolbarReload: false,
        },
        toolbar: {
        style: 'height: 60px;',
        items: [
                { type: 'html',  id: 'item1',
                html: function (item) {
                    var html =
                      '<datalist id="skulist">'+
                      @foreach (json_decode($skuoptionlist) as $query)
                      '  <option data-value="{{ $query->id }}" value="{{ $query->text }}"></option>'+
                      @endforeach
                      '</datalist>'+
                      '<div style="padding: 3px 3px;margin-top:-5px;">'+
                        '<table style="border-spacing: 5px;border-collapse: separate;width:100%;">'+
                        '<tr>'+
                            '<td>Product</td>'+
                            '<td align="center">Qty</td>'+
                            '<td align="center">Use</td>'+
                            '<td></td>'+
                            '<td align="center">Balance</td>'+
                            '<td align="center" width="100px;">Unit</td>'+
                            '<td align="center">Batch No</td>'+
                            '<td></td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td><input id="sku" name="sku"  oninput="onInput()" list="skulist" style="width: 300px" placeholder="Search product"  autocomplete="off" readonly></td>'+
                            '<td><input id="skuqty" style="width: 50px" type="number" onchange="updatechekqty(this.value);" placeholder="Qty" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" readonly></td>'+
                            '<td><input id="checkqty" style="width: 50px" placeholder="Qty" value="0" readonly></td>'+
                            '<td>/</td>'+
                            '<td><input id="balqty" style="width: 50px"  placeholder="Qty" value="0" readonly></td>'+
                            '<td><input id="uom" style="width: 50px" placeholder="Unit" value="" readonly></td>'+
                            '<td><input id="batchno" style="width: 100px" placeholder="Batch No" readonly></td>'+
                            '<td><button class="w2ui-btn" onclick="addsku();">Add</button></td>'+
                        '</tr>'+
                        '</table>'+
                      '</div>';
                    return html;
                    }
                }
            ],
            onClick: function (target, data) {
                console.log(target);
            }
        },
        columns: [
            { field: 'Code', text: 'Code', size: '70px' },
            { field: 'product', text: 'Product', size: '100%' },
            { field: 'productgroup', text: 'Product Group', size: '100px' },
            { field: 'batchno', text: 'Batch No', size: '80px' },
            { field: 'qty', text: 'Qty', size: '40px' },
            { field: 'qtyrate', text: 'Use', size: '60px' },
            { field: 'balqty', text: 'Balance', size: '60px' },
            { field: 'uom', text: 'Unit', size: '60px' },       
            { field: 'action', text: 'Action', size: '60px' ,
            render: function (record) { 
               var html; 
               html = '<center><i class="fa fa-times" onclick="deletesku('+record.recid+','+record.batchno+');"></i></center>'; 
            return html; } 
            }
        ],
        records: [
        ]
    },
    grid2: {
        name: 'grid2',
        show : {
          toolbar: false,
          footer: true,
          toolbarSearch: false,
          toolbarInput: false,
          toolbarReload: false,
        },
        columns: [
            { field: 'Code', text: 'Code', size: '80px' },
            { field: 'product', text: 'Product', size: '100%' },
            { field: 'productgroup', text: 'Product Group', size: '100px' },
            { field: 'batchno', text: 'Batch No', size: '80px' },
            { field: 'qty', text: 'Qty', size: '60px' },
            { field: 'qtyrate', text: 'Use', size: '60px' },
            { field: 'balqty', text: 'Balance', size: '60px' },
            { field: 'uom', text: 'Unit', size: '50px' },
        ],
        records: [
        ]
    }
};

function onInput() {
    
    if(document.getElementById("sku").value==""){
        $( "#balqty" ).val(0);
        $( "#skuqty" ).val(0);
    }else{
    w2ui['grid1'].lock();
    var val = document.getElementById("sku").value;
    var opts = document.getElementById('skulist').childNodes;
    for (var i = 0; i < opts.length; i++) {
      if (opts[i].value === val) {
        var codeno = val.split(" - ");
        var formData = {
          _token: "{{ csrf_token() }}",
            codeno : codeno[0],
            orderno : w2ui['form'].record['orderno'],
            doctorid : w2ui['form'].record['doctorid']['id']
        };
        $.ajax({
            type: 'POST',
            url: '/getbalqty',
            data: formData,
            dataType: 'json',
	        success: function (data) {

                w2ui['grid1'].unlock();
                console.log(data);

                $( "#productrate" ).val(data[0]['rate']);
                $( "#uom" ).val(data[0]['uom']);
                $( "#balqty" ).val(data[0]['balqty']);

                $("#skuqty").attr("readonly", false);
                $("#batchno").attr("readonly", false);

            },
            error: function (data) {
                w2alert('Error4.');
            }
        });
        // An item was selected from the list!
        // yourCallbackHere()
        //alert(opts[i].value);
        break;
      }
    }
    }
  }
function getbalqty() {
  //if (!e.keyCode) { // OR: if (e.keyCode === undefined)
    var codeno = $( "#sku" ).val().split(" - ");

    var formData = {
      _token: "{{ csrf_token() }}",
        codeno : codeno[0],
        orderno : w2ui['form'].record['orderno'],
        doctorid : w2ui['form'].record['doctorid']['id']
    };
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: '/getbalqty',
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $( "#productrate" ).val(data[0]['rate']);
            $( "#uom" ).val(data[0]['uom']);
            $( "#balqty" ).val(data[0]['balqty'])
        },
        error: function (data) {
            w2alert('Error.');
        }
    });
    console.log();
  //}
}
function updatechekqty(qty) {
    $( "#checkqty" ).val(qty * $( "#productrate" ).val());
    console.log();
  //}
}
$(function () {
    $('#layout').w2layout(config.layout);
    $('#layout2').w2layout(config2.layout);
	$('#layout4').w2layout(config4.layout);
    //$('#layout2').w2layout(config2.layout);
    //$('#layout3').w2layout(config3.layout);
    
    /*<?php 
    if(Auth::user()->territorytypeid!=1){
        echo "$().w2form(configdisable.form);";
        echo "$().w2grid(config3.grid1);";
        echo "$().w2grid(config4.grid4);";
    }else{
        if(Auth::user()->territoryid==0){
        
            echo "$().w2form(configdisable.form);";
            echo "$().w2grid(config3.grid1);";
        }else{  
            echo "$().w2form(config.form);";
            echo "$().w2grid(config2.grid1);";
        }   
    }
    ?>*/
    $().w2grid(config2.grid2);
    $().w2form(config2.form2);
    //w2ui.layout2.html('main', w2ui.grid1);
    //w2ui.layout3.html('main', w2ui.grid3);
});
$(document).ready(function() {
$("#sku").on('input', function () {
    var val = this.value;
    if($('#skulist option').filter(function(){
        return this.value.toUpperCase() === val.toUpperCase();        
    }).length) {
        //send ajax request
        alert(this.value);
    }
});
});

function openPopup(status,territorytypeid,doctorid,orderby,source,type) {
            territoryid = <?php echo Auth::user()->territoryid; ?>;
            w2ui['form'].enable('reference','orderdate','enddate','customerid','productid','doctorid');
            w2ui['form2'].enable('remark');
            if(status>0){
                if(type=='R'){
                    w2ui['form'].disable('reference','orderno','orderdate','enddate','productid','customerid','doctorid','status');
                    w2ui['form2'].disable('remark');
                    btn = '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> ';
                }else if(type=='A'){
                    w2ui['form'].disable('reference','orderno','orderdate','enddate','productid','customerid','doctorid','status');
                    w2ui['form2'].disable('remark');
                    if(status==1 || status==5 ){
                        btn = '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> '+
                              '<button id="rejectbtn" class="w2ui-btn" onclick="reject();">Reject</button>'+
                              '<button id="approvebtn" class="w2ui-btn" onclick="approve();" ">Approve</button>';
                    }else{
                        btn = '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> ';
                    }
                }else{
                    w2ui['form'].disable('reference','orderno','orderdate','enddate','productid','customerid','doctorid','status');
                    w2ui['form2'].disable('remark');
			
			        if(status==2){
                        btn = '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> '+
                        '<button id="rejectbtn" class="w2ui-btn" onclick="rejectadmin();">Reject</button>';
                    }else{
                        btn = '<button class="w2ui-btn" onclick="w2popup.close();">Close</button>';
                    }
                }
            }else{
                if(type=='R'){
                    btn = '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> '+
                      '<button id="savebtn" class="w2ui-btn" onclick="save(0);">Save</button>'+
                      '<button id="submitbtn" class="w2ui-btn" onclick="save(1);">Submit</button>';
                }else{
                    w2ui['form'].disable('reference','orderno','orderdate','enddate','productid','customerid','doctorid','status');
                    w2ui['form2'].disable('remark');
                    btn = '<button class="w2ui-btn" onclick="w2popup.close();">Close</button>'; 
                }
                
            }
            
    w2popup.open({
        title   : 'Sample Order',
        showMax : true,
        width   : 800,
        height  : 620,
        body    : '<div id="main" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"></div>',
        
        buttons:  btn,
        onOpen  : function (event) {
            event.onComplete = function () {
            var formData = {
                _token: "{{ csrf_token() }}",
            };

            //console.log(w2ui.form);
            $('#w2ui-popup #main').w2render('layout');

                w2ui.layout.html('top', w2ui.form);
                w2ui.layout.html('main', w2ui['layout2']);  
                if(type=='R'){
                    if(status == 1 || status == 2  || status == 3){
                        w2ui.layout2.html('top', w2ui.grid2);
                    }else{
                        w2ui.layout2.html('top', w2ui.grid1);
                    }
                }else if(type=='A'){
                    w2ui.layout2.html('top', w2ui['layout4']); 
                    w2ui.layout4.html('top', w2ui.grid2);
                    w2ui.layout4.html('main', w2ui.grid4);
                }else{
                    w2ui.layout2.html('top', w2ui['layout4']); 
                    w2ui.layout4.html('top', w2ui.grid1);
                    w2ui.layout4.html('main', w2ui.grid4);
                }
                w2ui.layout2.html('main', w2ui.form2);
               
              
                var formData = {
                  _token: "{{ csrf_token() }}",
                    skulist : $( "#productlist" ).val(),
                    qtylist : $( "#qtylist" ).val(),
                    batchnolist : $( "#batchnolist" ).val(),
                    orderno : w2ui['form'].record['orderno'],
                    doctorid : doctorid
                };
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '/getskulist2',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        w2ui['grid1'].clear();
                        w2ui['grid1'].add(data.query);
                        w2ui['grid2'].clear();
            			w2ui['grid2'].add(data.query);
            			if(type != 'R'){
                            console.log(data.query2);
                            w2ui['grid4'].clear();
                            w2ui['grid4'].add(data.query2);
                        }
                        if(w2ui['form'].record['doctorid']['id']==undefined){
                        }else{
                            $("#sku").attr("readonly", false);
                            $("#skuqty").attr("readonly", false);
                            $("#batchno").attr("readonly", false);
                        }
                    },
                    error: function (data) {
                        w2alert('Error.');
                    }
                });


              //w2ui.grid1.add($( "#productlistjson" ).val());

              $(".datepicker").datepicker();
              $(".datepicker").datepicker({
                dateFormat: 'yyyy-MM-dd'
              });
            };
        },
        onToggle: function (event) {
            event.onComplete = function () {
                w2ui.layout.resize();
            }
        }
    });
}


</script>
<script>
$(function () {
  search();
  $('#grid').w2grid({
    name: 'grid',
    show: {
        footer          : true,
        toolbarColumns  : false,
        toolbarSearch   : false,
        toolbarReload   : false,
        toolbarInput    : false,
        searchAll       : false,
        toolbar         : false,
        toolbarSave     : false
    },
    columns: [
        { field: 'reference', text: 'Reference No', size: '90px', sortable: true },
        { field: 'orderno', text: 'Order No', size: '100px', sortable: true },
        { field: 'principalname', text: 'Principal', size: '90px', sortable: true },
        { field: 'doctorcode', text: 'HCP Code', size: '100px', sortable: true },
        { field: 'doctorname', text: 'HCP Name', size: '160px', sortable: true },
        { field: 'shiptocode', text: 'Ship to Code', size: '90px', sortable: true },
        { field: 'shiptoname', text: 'Ship to Name', size: '220px', sortable: true },
        { field: 'orderdate', text: 'Date', size: '90px', sortable: true},
        { field: 'orderbyname', text: 'Order By', size: '100px', sortable: true},
        { field: 'statusdisplay', text: 'Status', size: '100px', sortable: true},
        { field: 'zpstatusdisplay', text: 'ZP Status', size: '100px', sortable: true},



    ],
    onDblClick: function(event) {
        source = 'edit';
        var grid = this;
        event.onComplete = function () {
            var sel = grid.getSelection();
            data = grid.get(sel[0]);
            console.log(data);
            //$().w2form(config.form);
            //$().w2grid(config2.grid1);
            //$().w2form(configdisable.form);
            //().w2grid(config3.grid1);
            //$().w2grid(config4.grid4);
            if(data.type !='R'){
                $().w2form(configdisable.form);
                $().w2grid(config3.grid1);
                $().w2grid(config4.grid4);
            }else{
                $().w2form(config.form);
                $().w2grid(config2.grid1);
            }
            w2ui['form'].record['id'] = data.id;
            w2ui['form'].record['recid'] = data.recid;
            w2ui['form'].record['reference'] = data.reference;
            w2ui['form2'].record['remark'] = data.remark;
            w2ui['form'].record['orderno'] = data.orderno;
            w2ui['form'].record['orderdate'] = data.orderdate;
            w2ui['form'].record['doctorid'] = data.doctorid;
            w2ui['form'].record['customerid'] = data.customerid;
            w2ui['form'].record['status'] = data.status;
            $('#productlist').val(data.productidlist);
            $('#qtylist').val(data.qtylist);
	    
            $('#batchnolist').val(data.batchnolist);
            $('#productbatchnolist').val(data.productbatchnolist);
		    $('#thisstatus').val(data.status);
            $('#thisterritorytypeid').val(<?php echo Auth::user()->territorytypeid; ?>);

            
            console.log(w2ui['form'].record['doctorid']);
            w2ui['form'].refresh();


            openPopup(data.status,<?php echo Auth::user()->territorytypeid; ?>,data.doctorid,data.orderby,'edit',data.type);
            //console.log(data);
        }
    }
  });
});



function search(){
  reference = $('#searchreference').val();
  orderno = $('#searchorderno').val();
  hcp = $('#searchhcp').val();
  customer = $('#searchcustomer').val()
  product = $('#searchproduct').val();
  var status_arr = $('#searchstatus').val();
  status = status_arr.join(", ");
  var formData = {
    _token: "{{ csrf_token() }}",
      reference: reference,
      orderno: orderno,
      hcp: hcp,
      customer: customer,
      product: product,
      status:status,
      //dashboardtype: dashboardtype,
  };
  $.ajax({
      type: 'POST',
      url: '/getsampleorder',
      data: formData,
      dataType: 'json',
      success: function (data) {
          w2ui['grid'].clear();
          console.log(data);
          w2ui['grid'].add(data);
      },
      error: function (data) {
          w2alert('Error.');
      }
  });
}
function addsampleorder(){
  source = 'add';
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = yyyy + '-' + mm + '-' + dd;

        $().w2form(config.form);
        $().w2grid(config2.grid1);
        //$().w2form(configdisable.form);
        //$().w2grid(config3.grid1);
        //$().w2grid(config4.grid4);

  w2ui['form'].record['id'] = "";
  w2ui['form'].record['recid'] = "";
  w2ui['form'].record['reference'] = "";
  w2ui['form2'].record['remark'] = "";
  w2ui['form'].record['orderno'] = "";
  w2ui['form'].record['orderdate'] = today;
  w2ui['form'].record['doctorid'] = "";
  w2ui['form'].record['customerid'] = "";
  w2ui['form'].record['status'] = 0;
  w2ui['form'].refresh();
  $('#productlist').val('');
  $('#qtylist').val('');
  $('#batchnolist').val('');
  $('#productbatchnolist').val('');
  w2ui.grid1.clear(); 
  w2ui.grid2.clear(); 
  openPopup(0,<?php echo Auth::user()->territorytypeid; ?>,0,<?php echo Auth::user()->id; ?>,'new','R');
}

function save(savetype){
    w2popup.lock("Loading...", true);
    if(w2ui['form'].record['orderdate']==""){
        w2alert('Order date empty.');
        return false;
    }
    if(w2ui['form'].record['customerid']['id']==undefined ){
        w2alert('No Customer selected.');
        return false;
    }
    if(w2ui['form'].record['doctorid']['id']==undefined){
        w2alert('No HCP selected.');
        return false;
    }

    if($('#productlist').val()==""){
        w2alert('No product selected.');
        return false;
    }


    var formData = {
      _token: "{{ csrf_token() }}",
      skulist : $( "#productlist" ).val(),
      qtylist : $( "#qtylist" ).val(),
      orderno : w2ui['form'].record['orderno'],
      doctorid : w2ui['form'].record['doctorid']['id'],
      customerid : w2ui['form'].record['customerid']['id']
    };
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: '/checkquota',
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data['customerinfo'][0]['sample']);
            if(data['customerinfo'][0]['countryid']==1){
                if(data['customerinfo'][0]['sample']==0){
                    msg = data['customerinfo'][0]['shiptoname'] + ' are not sample account. Are you sure?';
                }else{
                    msg = 'Are you sure?';
                }
            }else{
                msg = 'Are you sure?';
            }
            var myStringArray = data['productgrouplist'];
            var myStringArrayqty = data['productgroupqty'];
            var myStringArraybalqty = data['productgroupbalqty'];
            var myStringArrayname = data['productgroupname'];
            var arrayLength = myStringArray.length;
            for (var i = 0; i < arrayLength; i++) {
                if(myStringArrayqty[myStringArray[i]['productgroupid']] > myStringArraybalqty[myStringArray[i]['productgroupid']]){
                     w2alert(myStringArrayname[myStringArray[i]['productgroupid']]+' quota reached '+myStringArrayqty[myStringArray[i]['productgroupid']]+'/'+myStringArraybalqty[myStringArray[i]['productgroupid']]);
                    return false;
                }
            }

            w2confirm(msg, function btn(answer) {
		if(answer=='Yes'){
		w2popup.lock("Loading...", true);
                  var formData = {
                    _token: "{{ csrf_token() }}",
                    id : w2ui['form'].record['id'],
                    recid : w2ui['form'].record['recid'],
                    reference : w2ui['form'].record['reference'],
                    orderno : w2ui['form'].record['orderno'],
                    orderdate : w2ui['form'].record['orderdate'], 
                    doctorid : w2ui['form'].record['doctorid']['id'],
                    customerid : w2ui['form'].record['customerid']['id'],
                    status : savetype,
                    productlist : $('#productlist').val(),
                    qtylist : $('#qtylist').val(),
                    batchnolist : $('#batchnolist').val(),
                    remark : w2ui['form2'].record['remark'],
                  };
                  console.log(formData);
                  $.ajax({
                      type: 'POST',
                      url: '/savesampleorder',
                      data: formData,
                      dataType: 'json',
		      success: function (data) {
			if(data['success'] == true){
                            w2alert('Record updated.')
                            .ok(function () {
                                search();
                                w2popup.close();
                            });
                        }else{
                            w2alert(data['errormsg']);
                        }
                      },
                      error: function (data) {
                          w2alert('Error.');
                      }
                  });
                }else{
                  return false;
                }
            });
        },
        error: function (data) {
            w2alert('Error.');
        }
    });
}

function approve(){

    if($('#productlist').val()==""){
        w2alert('No product selected.');
        return false;
    }
    w2confirm('Approve?', function btn(answer) {
        if(answer=='Yes'){
          var formData = {
            _token: "{{ csrf_token() }}",
            id : w2ui['form'].record['id'],
            recid : w2ui['form'].record['recid'],
            reference : w2ui['form'].record['reference'],
            orderno : w2ui['form'].record['orderno'],
            orderdate : w2ui['form'].record['orderdate'], 
            doctorid : w2ui['form'].record['doctorid']['id'],
            customerid : w2ui['form'].record['customerid']['id'],
            status : w2ui['form'].record['status']['id'],
            productlist : $('#productlist').val(),
            qtylist : $('#qtylist').val(),
            remark : w2ui['form2'].record['remark'],
          };
          console.log(formData);
          /*$.ajax({
              type: 'POST',
              url: '/savesampleorder',
              data: formData,
              dataType: 'json',
              success: function (data) {*/
                  $.ajax({
                      type: 'POST',
                      url: '/approvesampleorderportal',
                      data: formData,
                      dataType: 'json',
                      success: function (data) {
		          
                        if(data['success'] == true){
		               w2alert('Order Approved.')
                              .ok(function () {
                                   search();
                                   w2popup.close();
			      });
			}else{
                            w2alert(data['errormsg']);
                        }
                      },
                      error: function (data) {
                          w2alert('Error.');
                      }
                  });
              /*},
              error: function (data) {
                  w2alert('Error.');
              }
          });*/
        }else{
          return false;
        }
    });
}

function reject(){

    if($('#productlist').val()==""){
        w2alert('No product selected.');
        return false;
    }
    w2confirm('Reject?', function btn(answer) {
        if(answer=='Yes'){
          var formData = {
            _token: "{{ csrf_token() }}",
            id : w2ui['form'].record['id'],
            recid : w2ui['form'].record['recid'],
            reference : w2ui['form'].record['reference'],
            orderno : w2ui['form'].record['orderno'],
            orderdate : w2ui['form'].record['orderdate'], 
            doctorid : w2ui['form'].record['doctorid']['id'],
            customerid : w2ui['form'].record['customerid']['id'],
            status : w2ui['form'].record['status']['id'],
            productlist : $('#productlist').val(),
            qtylist : $('#qtylist').val(),
            remark : w2ui['form2'].record['remark'],
          };
          console.log(formData);
          $.ajax({
              type: 'POST',
              url: '/rejectsampleorderportal',
              data: formData,
              dataType: 'json',
	      success: function (data) {
                   if(data['success'] == true){
                	w2alert('Order Rejected.')
                	.ok(function () {
                    	    search();
                    	    w2popup.close();
			});
		   }else{
                        w2alert(data['errormsg']);
                   }
              },
              error: function (data) {
                  w2alert('Error.');
              }
          });
        }else{
          return false;
        }
    });
}

function rejectadmin(){

    if($('#productlist').val()==""){
        w2alert('No product selected.');
        return false;
    }
    w2confirm('Reject?', function btn(answer) {
        if(answer=='Yes'){
          var formData = {
            _token: "{{ csrf_token() }}",
            id : w2ui['form'].record['id'],
            recid : w2ui['form'].record['recid'],
            reference : w2ui['form'].record['reference'],
            orderno : w2ui['form'].record['orderno'],
            orderdate : w2ui['form'].record['orderdate'], 
            doctorid : w2ui['form'].record['doctorid']['id'],
            customerid : w2ui['form'].record['customerid']['id'],
            status : w2ui['form'].record['status']['id'],
            productlist : $('#productlist').val(),
            qtylist : $('#qtylist').val(),
            remark : w2ui['form2'].record['remark'],
          };
          console.log(formData);
          $.ajax({
              type: 'POST',
              url: '/rejectsampleorderadmin',
              data: formData,
              dataType: 'json',
          success: function (data) {
                   if(data['success'] == true){
                    w2alert('Order Rejected.')
                    .ok(function () {
                            search();
                            w2popup.close();
            });
           }else{
                        w2alert(data['errormsg']);
                   }
              },
              error: function (data) {
                  w2alert('Error10.');
              }
          });
        }else{
          return false;
        }
    });
}

function searchdashboardtype(){
    search2($('#viewdashboardid').val());
    search3($('#viewdashboardid').val());
    search4($('#viewdashboardid').val());
    search5($('#viewdashboardid').val());
};
</script>
<script>
$( "#pushme" ).click(function() {
  setTimeout(function(){ w2ui['grid'].refresh(); }, 100);
});

function cleardateresigned() {
  w2ui['form'].record['dateresigned'] = '';
  w2ui['form'].refresh();
}
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Sample Order</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">

        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
<style>
table.dataTable tbody th, table.dataTable tbody td {
  padding-top: 5px;
  padding-bottom: 5px;
}
</style>
  <!-- Main content -->


<style>
.w2ui-field input {
    width: 200px;
}
.w2ui-field > div > span {
    margin-left: 20px;
}
</style>
<style> .w2ui-overlay { width:500px; } </style>
<script type="text/javascript">
</script>
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-12">
            <input type="hidden" id="thisstatus">
            <input type="hidden" id="thisterritorytypeid">
            <input type="text" id="productlist">
            <input type="text" id="qtylist">
            <input type="hidden" id="batchnolist">
            <input type="hidden" id="productbatchnolist">
            <input type="text" id="productrate">
            Reference No
            <input type="text" id="searchreference" style="width:80px;">
            Order No
	    <input type="text" id="searchorderno" style="width:80px;">
	    HCP
            <input type="text" id="searchhcp" style="width:130px;">
            Customer
	    <input type="text" id="searchcustomer" style="width:130px;">
            Product
            <input type="text" id="searchproduct" style="width:130px;">
            Status
            <select id="searchstatus" class="selectpicker"  title="All" multiple data-actions-box="true" data-selected-text-format="count"  data-width="100px">
	      <option value="0">Saved</option>
	      <option value="1">Waiting For Approval</option>
              <option value="2">Approved</option>
              <option value="3">Rejected</option>
            </select>
            <button onclick="search();" class="bg-gradient-secondary"> Search </button>
            <button id="addsampleorderBtn" name="addsampleorderBtn" onclick="addsampleorder();" >Add</button>
            <!---button id="excel" name="excel" onclick="download();">Excel</button--->
            <div style="background-color: white;">
            <!---i class="fa fa-edit"></i>
            <i class="fa fa-chart-line"></i>
            <i class="fa fa-file"></i--->
            </div>
        </div>
        <div class="col-lg-12 col-12">
          <div id="grid" style="width: 100%; height: 400px;"></div>
        </div>
          <!-- /.card -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

<!---script src="https://cdn.bootcss.com/dom-to-image/2.6.0/dom-to-image.min.js"></script>
<script src="https://cdn.bootcss.com/FileSaver.js/2014-11-29/FileSaver.min.js"></script--->
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script type="text/javascript">
    function downloadimage(){
            html2canvas(document.getElementById('my-node')).then(function(canvas) {
            
              var a = document.createElement('a');
                    a.href = canvas.toDataURL("image/png");       
                    a.download = 'sampleorder Dashboard.png';
                    a.click();

           });
        }
</script>
    <div id="popup1" style="display: none; width: 95%; height: 100%; overflow: hidden">
        <div rel="title">
            Dashboard
        </div>
        <div rel="body" style="padding: 10px; line-height: 150%" id="my-node">

      <div class="row">
        <section class="col-lg-7">
            <div class="row">
                <div class="overlay-div" id="overlay-div1">
                  <div class="cv-spinner">
                    <span class="spinner"></span>
                  </div>
                </div>
                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-teal" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:5px;padding-top:5px;">
                      <span style="font-size:20px;font-weight: bold;" id="mtdsales">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">MTD Sales </span>
                      <br>
                      <span style="font-size:20px;font-weight: bold;" id="lymtdsales">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">LY MTD Sales </span>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-teal"style="margin-bottom:2px;">
                    <div class="inner" style="padding-bottom:5px;padding-top:5px;">
                      <span style="font-size:20px;font-weight: bold;" id="mtdtarget">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">MTD TGT </span>
                      <br>
                        <span style="font-size:20px;font-weight: bold;" id="">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">&nbsp;</span>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-teal" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:5px;padding-top:5px;">
                        <span style="font-size:20px;font-weight: bold;" id="mtdperf">&nbsp;</span>
                        <br>
                        <span style="font-weight: normal;">Performance </span>
                        <br>
                        <span style="font-size:20px;font-weight: bold;" id="mtdgrowth">&nbsp;</span>
                        <br>
                        <span style="font-weight: normal;">VS LY </span>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>

                </div>
                <!-- ./col -->
            </div>  
            <div class="row">
                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-info" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:5px;padding-top:5px;">
                      <span style="font-size:20px;font-weight: bold;" id="ytdsales">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">YTD Sales </span>
                      <br>
                        <span style="font-size:20px;font-weight: bold;" id="lyytdsales">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">LYTD Sales </span>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-info" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:5px;padding-top:5px;">
                      <span style="font-size:20px;font-weight: bold;" id="ytdtarget">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">YTD TGT </span>
                      <br>
                        <span style="font-size:20px;font-weight: bold;" id="">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">&nbsp;</span>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-info" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:5px;padding-top:5px;">
                        <span style="font-size:20px;font-weight: bold;" id="ytdperf">&nbsp;</span>
                        <br>
                        <span style="font-weight: normal;">Performance </span>
                        <br>
                        <span style="font-size:20px;font-weight: bold;" id="ytdgrowth">&nbsp;</span>
                        <br>
                        <span style="font-weight: normal;">VS LY </span>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">  
                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-purple" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:7px;padding-top:5px;">
                      <span style="font-size:20px;font-weight: bold;" id="fullsales">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">YTD Sales </span>
                        <br>
                        <br>
                        <br>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-purple" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:7px;padding-top:5px;">
                      <span style="font-size:20px;font-weight: bold;" id="fulltarget">&nbsp;</span>
                      <br>
                      <span style="font-weight: normal;">YTD TGT </span>
                        <br>
                        <br>
                        <br>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-4">
                  <!-- small box -->
                  <div class="small-box bg-purple" style="margin-bottom:5px;">
                    <div class="inner" style="padding-bottom:7px;padding-top:5px;">
                        <span style="font-size:20px;font-weight: bold;" id="fullperf">&nbsp;</span>
                        <br>
                        <span style="font-weight: normal;">Performance </span>
                        <br>
                        <br>
                        <br>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="col-lg-5 ">
          <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales by State
                </h3>
              </div><!-- /.card-header --> 
              <div class="overlay-div" id="overlay-div3">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
              <style>
              .chart-legend li span{
                  display: inline-block;
                  width: 12px;
                  height: 12px;
                  margin-right: 5px;

              }
              ul {
                list-style-type: none;
                padding-inline-start: 10px;
              }
              </style>
              <div class="card-body">
                <div class="row">
                  <!-- Morris chart - Sales -->

                  <div class="col-md-8">
                    <div class="chart tab-pane active " id="chart2" style="height: 190px" >
                        <canvas id="chart2-canvas"></canvas>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div id="js-legend" class="chart-legend" style="overflow:auto;height: 160px;font-size:10px;">

                     </div>
                  </div>
              </div><!-- /.card-body -->    
          </div>

          <!-- /.card -->
        </section>
        <!-- Left col -->
        
    </div>
        
    <div class="row">
        <section class="col-lg-7">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Sales

                  </h3>
                  <div class="card-tools">
                    Start
                    <input id="chart-startdate" class="w2ui-input" style="width:100px;" placeholder="" onchange="search2();">
                    End
                    <input id="chart-enddate" class="w2ui-input" style="width:100px;" placeholder="" onchange="search2();">
                </div>
                </div><!-- /.card-header -->
                <div class="overlay-div" id="overlay-div2">
                  <div class="cv-spinner">
                    <span class="spinner"></span>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart tab-pane active" id="chart1"  style="height: 460px">
                      <canvas id="chart1-canvas"></canvas>
                   </div>
                </div><!-- /.card-body -->
            </div>
        </section>
        <section class="col-lg-5">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Top 20 Customer
                  </h3>
                </div><!-- /.card-header -->
                <div class="overlay-div" id="overlay-div6">
                  <div class="cv-spinner">
                    <span class="spinner"></span>
                  </div>
                </div>
                <div class="card-body">
                    <div class="chart tab-pane active" id="chart3" style="height: 460px" >
                        <canvas id="chart3-canvas"></canvas>
                     </div>
                </div><!-- /.card-body -->
            </div>
        </section>
    </div>
        <!-- /.Left col -->
    <div rel="buttons">
          <select id="dashboardtype" class="w2ui-input" style="font-size: 14px;" onchange="searchdashboardtype();">
            <option value="qty" selected>Qty</option> 
            <option value="sls">Value</option>
          </select>
        <button class="w2ui-btn" onclick="w2popup.close()">Close</button>
        <button class="w2ui-btn" onclick="downloadimage()">Download Image</button>
    </div>
</div>

    </div><!-- /.container-fluid -->


    <style type="text/css">
        [data-id="searchyear"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchperiod"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchflm"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchmr"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchproductgroup"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchchannel"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchsubchannel2"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchbu"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchsource"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchtagging"] {
            padding: 3px;
            font-size: 12px;
        }
        [data-id="searchseq"] {
            padding: 3px;
            font-size: 12px;
        }
    </style>
    


                
<script type="text/javascript">




    function search3(sampleorderid){
        dashboardtype = $('#dashboardtype').val();
        //var sampleorderid = $('#viewdashboardid').val();

        var formData = {
            _token: "{{ csrf_token() }}",
            sampleorderid:sampleorderid ,
            dashboardtype: dashboardtype,
        };

        var coloR = [];

        coloR.push("rgb(255,99,132,0.5)");
        coloR.push("rgb(255,159,64,0.5)");
        coloR.push("rgb(255,205,86,0.5)");
        coloR.push("rgb(75,192,192,0.5)");
        coloR.push("rgb(54,162,235,0.5)");
        coloR.push("rgb(153,102,255,0.5)");
        coloR.push("rgb(201,203,207,0.5)");
        coloR.push("rgb(254,197,234,0.5)");
        coloR.push("rgb(204, 204, 255,0.5)");
        coloR.push("rgb(255, 0, 255,0.5)");
        coloR.push("rgb(0, 128, 128,0.5)");
        coloR.push("rgb(255, 127, 80,0.5)");
        coloR.push("rgb(0, 0, 128,0.5)");
        coloR.push("rgb(0, 255, 0,0.5)");

        $.ajax({
            beforeSend: function () {
                $("#overlay-div3").height($("#overlay-div3").parent().height());
                $("#overlay-div3").fadeIn(300);
            },
            type: 'POST',
            url: '/getsampleorderdashboard3',
            data: formData,
            dataType: 'json',
            success: function (data) {
                // console.log(data); return;
                $("#chart2-canvas").remove();
                $("#chart2").append('<canvas id="chart2-canvas" class="animated fadeIn"></canvas>');
                var total = data.total;
                var config = {
                    type: 'doughnut',
                    data: {
                    datasets: [{
                        data: JSON.parse(data.sales),
                        backgroundColor: coloR,
                        borderWidth: 1,
                        label: 'Dataset 1'
                    }],
                    labels: JSON.parse(data.label)
                    },
                    options: {
                        plugins: {
                            datalabels: {
                                display: false
                            }
                        },
                        tooltips: {
                            callbacks: {
                                title: function(tooltipItem, data) {
                                    return data['labels'][tooltipItem[0]['index']];
                                },
                                label: function(tooltipItem, data) {
                                    var percent = Math.round((data['datasets'][0]['data'][tooltipItem['index']] / total) * 100);
                                    return data['datasets'][0]['data'][tooltipItem['index']]+' (' + percent + '%)';
                                }
                            },
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        },legend: {
                            display: false,
                            position: 'right',
                            onClick: null,
                            labels: {
                                font: {
                                    size: 38
                                },
                                usePointStyle: true  //<-- set this
                            }
                        },
                    }
                };
                var ctx = document.getElementById('chart2-canvas').getContext('2d');
                ctx.height = 150;
                window.myDoughnut = new Chart(ctx, config);
                // console.log(window.myDoughnut.generateLegend());
                document.getElementById('js-legend').innerHTML = window.myDoughnut.generateLegend();
            },
            error: function (data) {
              w2alert('Error.');
            }
        }).done(function() {
        setTimeout(function(){
          $("#overlay-div3").fadeOut(300);
        },500);
        });
    }

    function search4(sampleorderid){
        dashboardtype = $('#dashboardtype').val();

        var formData = {
            _token: "{{ csrf_token() }}",
            sampleorderid:sampleorderid ,
            dashboardtype: dashboardtype,
        };
        $.ajax({
            beforeSend: function () {
            $("#overlay-div4").height($("#overlay-div4").parent().height());
            $("#overlay-div4").fadeIn(300);
        },
        type: 'POST',
        url: '/getsampleorderdashboard4',
        data: formData,
        dataType: 'json',
        success: function (data) {
            // console.log(data); return;
            $("#chart3-canvas").remove();
            $("#chart3").append('<canvas id="chart3-canvas" class="animated fadeIn"></canvas>');

            var horizontalBarChartData = {
                labels:JSON.parse(data.label),
                datasets: [{
                    label: 'Sales',
                    backgroundColor: 'rgb(56, 176, 195,0.5)',
                    borderColor: 'rgb(56, 176, 195)',
                    borderWidth: 1,
                    data: JSON.parse(data.sales)
                }]
            };

            var ctx = document.getElementById('chart3-canvas').getContext('2d');
            window.myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: horizontalBarChartData,
            options: {
                plugins: {
                    datalabels: {
                    display: true,
                    align: 'end',
                    anchor: 'start'
                    }
                },
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontSize: 8
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 12
                        }
                    }]
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                    position: 'top',
                },
            }
            });

        },
        error: function (data) {
          w2alert('Error.');
        }
        }).done(function() {
            setTimeout(function(){
                $("#overlay-div4").fadeOut(300);
            },500);
        });
    }
function pad(num, size) {
    num = num.toString();
    while (num.length < size) num = "0" + num;
    return num;
}
function search2(){
    sampleorderid = $('#viewdashboardid').val();
    dashboardtype = $('#dashboardtype').val();
    startdate = $('#chart-startdate').val();
    enddate = $('#chart-enddate').val();

    date1 = startdate.split('/');
    date2 = enddate.split('/');

    startdate = date1['2'] + '-' + pad(date1['1'],2) + '-' + pad(date1['0'],2);
    enddate = date2['2'] + '-' + pad(date2['1'],2) + '-' + pad(date2['0'],2);

    var formData = {
        _token: "{{ csrf_token() }}",
        sampleorderid:sampleorderid,
        dashboardtype: dashboardtype,
        startdate: startdate,
        enddate: enddate,
    };
    $.ajax({
        beforeSend: function () {
            $("#overlay-div2").height($("#overlay-div2").parent().height());
            $("#overlay-div2").fadeIn(300);
        },
        type: 'POST',
        url: '/getsampleorderdashboard2',
        data: formData,
        dataType: 'json',
        success: function (data) {
            // console.log(data); return;
            $("#chart1-canvas").remove();
            $("#chart1").append('<canvas id="chart1-canvas" class="animated fadeIn"></canvas>');

            var chartData = {
                labels: JSON.parse(data.label),
                datasets: [{
                    type: 'line',
                    label: 'Performance',
                    borderWidth: 1,
                    backgroundColor: 'rgb(68, 114, 196)',
                    borderColor: 'rgb(68, 114, 196)',
                    fill: false,
                    data: JSON.parse(data.perf),
                    yAxisID: 'y-axis-2'
                }/*,{
                    type: 'line',
                    label: 'Run Rate',
                    borderWidth: 2,
                    backgroundColor: 'rgb(255, 159, 64)',
                    borderColor: 'rgb(255, 159, 64)',
                    fill: false,
                    data: JSON.parse(data.runrate),
                    yAxisID: 'y-axis-2'
                }*/,{
                    type: 'bar',
                    label: 'Sales',
                    backgroundColor: JSON.parse(data.salescolor),
                    data: JSON.parse(data.sales),
                    borderColor: 'white',
                    borderWidth: 1,
                    yAxisID: 'y-axis-1'
                },{
                    type: 'bar',
                    label: 'Target',
                    backgroundColor: 'rgb(255, 61, 103)',
                    data: JSON.parse(data.target),
                    borderColor: 'white',
                    borderWidth: 1,
                    yAxisID: 'y-axis-1'
                },{
                    type: 'bar',
                    label: 'BTG',
                    backgroundColor: 'rgb(255, 195, 0)',
                    borderColor: 'white',
                    borderWidth: 1,
                    yAxisID: 'y-axis-1'
                }]

            };
            var ctx = document.getElementById('chart1-canvas').getContext('2d');
              ctx.height = 300;
              window.myMixedChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  elements: {
                      line: {
                          tension: 0
                      }
                  },
            legend: {
                labels: {
                  boxWidth: 10
                }
              },
            title: {
              display: false,
              text: ''
            },
            scales: {
                yAxes: [{
                  type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                  display: true,
                  position: 'left',
                  id: 'y-axis-1',
                  ticks: {
                     min: 0,
                      callback: function(value, index, values) {
                          return (value / 1e3).toLocaleString() + 'K';
                      }
                  }
                }, {
                  type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                  display: true,
                  position: 'right',
                  id: 'y-axis-2',
                  ticks: {
                      callback: function(value, index, values) {
                          return value + '%';
                      }
                  },

                  // grid line settings
                  gridLines: {
                    drawOnChartArea: false, // only want the grid lines for one axis to show up
                  },
                }],
              },
                tooltips: {
                   enabled: true,
                          mode: 'index',
                   intersect: true,
                          callbacks: {
                              label: function(tooltipItems, data) {
                            value = tooltipItems.yLabel
                            value = value.toString();
                            value = value.split(/(?=(?:...)*$)/);
                            value = data.datasets[tooltipItems.datasetIndex].label +' : ' + value.join(',');
                                        return value;
                              }
                          }
                },
                  plugins: {
                    datalabels: {
                       // hide datalabels for all datasets
                       display: false
                    }
                  }
                }
              });
      },
      error: function (data) {
          w2alert('Error.');
      }
  }).done(function() {
    setTimeout(function(){
      $("#overlay-div2").fadeOut(300);
    },500);
  });
}
function search5(sampleorderid){
  dashboardtype = $('#dashboardtype').val();
  var formData = {
    _token: "{{ csrf_token() }}",
      sampleorderid:sampleorderid ,
      dashboardtype: dashboardtype,
  };
  console.log(formData);
  $.ajax({
      beforeSend: function () {
        $("#overlay-div1").height($("#overlay-div1").parent().height()-20);
        $("#overlay-div1").fadeIn(300);
      },
      type: 'POST',
      url: '/getsampleorderdashboard',
      data: formData,
      dataType: 'json',
      success: function (data) {
        console.log(data);
        var nf = new Intl.NumberFormat();
        $('#mtdsales').html(nf.format(data.mtdsales));
        //$('#lymtdsales').html(nf.format(data.lymtdsales));
        $('#ytdsales').html(nf.format(data.cytdsales));
        //$('#lyytdsales').html(nf.format(data.lytdsales));
        $('#mtdtarget').html(nf.format(data.mtdtarget[0].tgt));
        $('#ytdtarget').html(nf.format(data.ytdtarget[0].tgt));

        $('#fullsales').html(nf.format(data.fullsales));
        $('#fulltarget').html(nf.format(data.fulltarget[0].tgt));
        $('#mtdperf').html(nf.format(data.perf)+"%");
        $('#ytdperf').html(nf.format(data.perf2)+"%");
        $('#fullperf').html(nf.format(data.fullperf)+"%");
        //$('#mtdgrowth').html(nf.format(data.growth)+"%");
        //$('#ytdgrowth').html(nf.format(data.growth2)+"%");
      },
      error: function (data) {
          w2alert('Error.');
      }
  }).done(function() {
    setTimeout(function(){
      $("#overlay-div1").fadeOut(300);
    },500);
  });
}
</script>
<script type="text/javascript">
    var y = $('#grid').position().top;
    var layoutHeight = $(window).height() - y - 240;
    $('#grid').css('height', layoutHeight + 'px');  
</script>

@endsection

