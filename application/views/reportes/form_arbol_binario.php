    <style type="text/css">
        

        #mynetwork {
            width: 900px;
            height: 600px;
            border: 1px solid black;
            margin: 0 auto;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/dist/vis.js"></script>
    <link href="<?php echo base_url(); ?>js/dist/vis-network.min.css" rel="stylesheet" type="text/css">


    <script type="text/javascript">
        var nodes = null;
        var edges = null;
        var network = null;
        //var directionInput = document.getElementById("direction");
        var directionInput ='UD';

        function destroy() {
            if (network !== null) {
                network.destroy();
                network = null;
            }
        }

        function draw() {
            destroy();
            get_matriz_ajax();
            nodes = [];
            edges = [];
            var connectionCount = [];
            var nombres= ['Eduardo','Pablo','Santiago','Tatiana','Daniela','Gabriela','Wilson','Hitler','Kara','Aquiles','Perseo','Patton','Romel','Balduino','Guillermo'];
            
            // randomly create some nodes and edges
            for (var i = 0; i < 15; i++) {
                nodes.push({id: i, label: String(nombres[i]),font: '20px'});
            }
            edges.push({from: 0, to: 1});
            edges.push({from: 0, to: 6});
            edges.push({from: 0, to: 13});
            edges.push({from: 0, to: 11});
            edges.push({from: 10, to: 2});
            edges.push({from: 2, to: 3});
            edges.push({from: 2, to: 4});
            edges.push({from: 3, to: 5});
            edges.push({from: 1, to: 10});
            edges.push({from: 1, to: 7});
            edges.push({from: 2, to: 8});
            edges.push({from: 2, to: 9});
            edges.push({from: 3, to: 14});
            edges.push({from: 1, to: 12});
            
            nodes[0]["level"] = 0;
            nodes[1]["level"] = 1;
            nodes[2]["level"] = 3;
            nodes[3]["level"] = 4;
            nodes[4]["level"] = 4;
            nodes[5]["level"] = 5;
            nodes[6]["level"] = 1;
            nodes[7]["level"] = 2;
            nodes[8]["level"] = 4;
            nodes[9]["level"] = 4;
            nodes[10]["level"] = 2;
            nodes[11]["level"] = 1;
            nodes[12]["level"] = 2;
            nodes[13]["level"] = 1;
            nodes[14]["level"] = 5;


            // create a network
            var container = document.getElementById('mynetwork');
            var data = {
                nodes: nodes,
                edges: edges
            };

            var options = {
                edges: {
                    smooth: {
                        type: 'cubicBezier',
                        forceDirection: (directionInput.value == "UD" || directionInput.value == "DU") ? 'vertical' : 'horizontal',
                        roundness: 0.5
                    }
                },
                layout: {
                    hierarchical: {
                        direction: directionInput.value
                    }
                },
                nodes:{ size: 2},
                physics:true
            };
            network = new vis.Network(container, data, options);

            // add event listeners
            network.on('select', function (params) {
                document.getElementById('selection').innerHTML = 'Selection: ' + params.nodes;
                alert('ID Seleccionado'+params.nodes);
            });
        }

        function get_matriz_ajax() {
          var socio_id = $('#id_socio').val();
          $.ajax({
            url: '<?php echo base_url(); ?>reportes/consultar_matriz_socio_ajax',
            type: 'POST',
            data: {id_socio: ''+socio_id},
          })
          .done(function(resp) {
            alert(resp);
            console.log("success: "+resp);
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
        }

</script>
<p style="display: none;">
    <input type="button" id="btn-UD" value="Up-Down">
    <input type="button" id="btn-DU" value="Down-Up">
    <input type="button" id="btn-LR" value="Left-Right">
    <input type="button" id="btn-RL" value="Right-Left">
    <input type="hidden" id="direction" value="UD">
</p>
<h2>Matriz Binaria</h2>
<div id="mynetwork">
  <div class="vis-network" tabindex="900" style="position: relative; overflow: hidden; touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 100%; height: 100%;">
  <canvas width="100%" height="600" style="position: relative; touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); width: 100%; height: 100%;"></canvas>
  </div>
</div>

<p id="selection"></p>
<script language="JavaScript">
    var directionInput = document.getElementById("direction");
    var btnUD = document.getElementById("btn-UD");
    btnUD.onclick = function () {
        directionInput.value = "UD";
        draw();
    };
    var btnDU = document.getElementById("btn-DU");
    btnDU.onclick = function () {
        directionInput.value = "DU";
        draw();
    };
    var btnLR = document.getElementById("btn-LR");
    btnLR.onclick = function () {
        directionInput.value = "LR";
        draw();
    };
    var btnRL = document.getElementById("btn-RL");
    btnRL.onclick = function () {
        directionInput.value = "RL";
        draw();
    };

    $(function(){
      draw();
    });
</script>
