


        var width = window.innerWidth - 20;
        var height = window.innerHeight - 200;
        imagesw = 130;
        imagesh = 130;
        centerImageW = 70;
        centerImageH = 70;
        var r = 40;

        var color = d3.scale.category20();

        var force = d3.layout.force()
            .charge(-2500)
            .linkDistance(height/5)
            .size([width, height]);

        var svg = d3.select(".video > #visualization").append("svg")
            .attr("width", width)
            .attr("height", height);

        var currentdate = new Date();
        var datetime = (currentdate.getFullYear()) + "-" + ("0" + (currentdate.getMonth() + 1)).slice(-2) + "-" + ("0" + currentdate.getDate()).slice(-2) + "-" + ("0" + currentdate.getHours()).slice(-2);



        var jsonfile = "../nodenews/backend/data/" + datetime + "/basic-graph-data.json";
        console.log(datetime);
        console.log(jsonfile);

        UpdateGraph(width, height, r, color, force, svg, jsonfile,640,datetime);

        function UpdateGraph(width, height, r, color, force, svg, json,TimescrollerX,TimescrollerY) {

            date = jsonfile.split("/");
                            date = date[3];
                            

            svg.selectAll("*").remove();



            d3.json(json, function(error, graph) {
                force
                    .nodes(graph.nodes)
                    .links(graph.links)
                    .start();

               /*var drag = d3.behavior.drag()
                    .on("drag", function(d) {
                        d.x += d3.event.dx
                        d.y += d3.event.dy
                        console.log(d.x + "," + d.y);

                        d3.select(this)
                            .attr("transform", function(d, i) {

                                d.x = Math.max(25, Math.min(width - 20, d.x));
                                d.y = Math.max(40, Math.min(height - 25, d.y));
                                var hours = Math.round(ScaleH(d.x,25,width));
                                var days = Math.round(ScaleD(d.y,40,height-40));
                                
                                
                                
                            
                            var currentdate = new Date();
                            var datetime = (currentdate.getFullYear()) + "-" + ("0" + (currentdate.getMonth() + 1)).slice(-2) + "-" + ("0" + (currentdate.getDate()-days)).slice(-2) + "-" + ("0" + hours).slice(-2);
                            
                            console.log(hours)
                                   var date = hours + ":00 february 2015";
                                

                                d3.select("#date")
                                  .text( 
                                    date
                                    );

                                return "translate(" + [d.x, d.y] + ")";
                            })


                        d3.select("#yDriver") // yDriver
                            .attr("x1", function(d) {
                                d.x1 += d3.event.dx;
                                d.x1 = Math.max(25, Math.min(width - 20, d.x1));
                                return d.x1;
                            })
                            .attr("y1", function(d) { //d.y1 += d3.event.dy;
                                //d.y1 = Math.max(40, Math.min(height - 25, d.y));
                                return d.y1;
                            })
                            .attr("x2", function(d) {
                                d.x2 += d3.event.dx;
                                d.x2 = Math.max(25, Math.min(width - 20, d.x2));
                                return d.x2;
                            })
                            .attr("y2", function(d) {
                                d.y2 += d3.event.dy;
                                d.y2 = Math.max(40, Math.min(height - 25, d.y2));
                                return d.y2;
                            })
                            .style("opacity","1");

                        d3.select("#xDriver") // xDriver
                            .attr("x1", function(d) {
                                d.x1 += d3.event.dx;
                                d.x1 = Math.max(25, Math.min(width - 20, d.x1));
                                return d.x1;
                            })
                            .attr("y1", function(d) {
                                d.y1 += d3.event.dy;
                                d.y1 = Math.max(40, Math.min(height - 25, d.y1));
                                return d.y1;
                            })
                            .attr("x2", function(d) { //d.x2 += d3.event.dx;
                                //d.x2 = Math.max(25, Math.min(width - 20, d.x2));
                                return d.x2;
                            })
                            .attr("y2", function(d) {
                                d.y2 += d3.event.dy;
                                d.y2 = Math.max(40, Math.min(height - 25, d.y2));
                                return d.y2;
                            })
                            .style("opacity","1");;


                        




                    })
                    .on("dragend", function(d) {

                        d3.select("#time-scroller")
                            .transition()
                            .duration(200)
                            .style("opacity", 0.1)
                            .transition()
                            .ease("elastic")
                            .duration(500)
                            .attr("r", 35);

                           d3.select("#time-scroller").attr("x",function(d){
                            var hours = Math.round(ScaleH(d.x,25,width));
                            var days = Math.round(ScaleD(d.y,40,height-40));
                            
                            var currentdate = new Date();
                            var datetime = (currentdate.getFullYear()) + "-" + ("0" + (currentdate.getMonth() + 1)).slice(-2) + "-" + ("0" + (currentdate.getDate()-days)).slice(-2) + "-" + ("0" + hours).slice(-2);
                            console.log(datetime);


                            UpdateGraph(width, height, r, color, force, svg, "../backend/data/" + date + "/" + "basic-graph-data.json",d.x,d.y);
                            
                           })
                            


                    })
                    .on("dragstart", function(d) {

                        d3.select("#time-scroller")
                            .style("opacity", 1)
                            .transition()
                            .ease("elastic")
                            .duration(500)
                            .attr("r", 40);

                        d3.select("#xDriver")
                        .style("opacity",1); // xDriver

                        d3.select("#yDriver")
                        .style("opacity",1); // yDriver

                    });*/

                                      
                      //setTimeScroller(TimescrollerX,TimescrollerY);
/*
                function setTimeScroller(holderX, holderY) {

                    svg.selectAll("#Holder").remove();
                    svg.selectAll("#yDriver").remove();
                    svg.selectAll("#xDriver").remove();

                    minX = 25;
                    minY = 40;
                    maxX = width - 40; //40 is radius
                    maxY = height- 40; //40 is radius

                    if(holderY >= minY && holderY <= maxY){

                    }else{
                      holderY = 200;
                      console.log("WRONG TIME VALUE.SET TO DEEFAULT");
                    }

                    if(holderX >= minX && holderX <= maxX){

                    }else{
                      holderX = 200;
                      console.log("WRONG TIME VALUE.SET TO DEEFAULT");
                    }

                    // yDriver starting points
                    var yDriverX1 = holderX;
                    var yDriverY1 = height - 25; //default never changes
                    var yDriverX2 = holderX;
                    var yDriverY2 = holderY + 35;
                    // xDriver starting points
                    var xDriverX1 = holderX - 35;
                    var xDriverY1 = holderY;
                    var xDriverX2 = 20; //default never changes
                    var xDriverY2 = holderY;



                    var holder = svg.append("svg:g")
                        .attr("id", "Holder")
                        .data([{
                            "x": holderX,
                            "y": holderY
                        }])
                        .attr("transform", "translate(" + holderX + "," + holderY + ")")
                        .call(drag);

                    var yDriver = svg.append("line")
                        .data([{
                            "x1": yDriverX1,
                            "y1": yDriverY1,
                            "x2": yDriverX2,
                            "y2": yDriverY2
                        }])
                        .attr("id", "yDriver")
                        .attr("class", "driver")
                        .attr("x1", yDriverX1)
                        .attr("y1", yDriverY1)
                        .attr("x2", yDriverX2)
                        .attr("y2", yDriverY2)
                        .style("opacity", 0.1)
                        .style("stroke-width", "1")
                        .style("stroke-dasharray", ("10, 2"));

                    var xDriver = svg.append("line")
                        .data([{
                            "x1": xDriverX1,
                            "y1": xDriverY1,
                            "x2": xDriverX2,
                            "y2": xDriverY2
                        }])
                        .attr("id", "xDriver")
                        .attr("class", "driver")
                        .attr("x1", xDriverX1)
                        .attr("y1", xDriverY1)
                        .attr("x2", xDriverX2)
                        .attr("y2", xDriverY2)
                        .style("opacity", 0.1)
                        .style("stroke-width", "1")
                        .style("stroke-dasharray", ("10, 2"));

                    var time_scroller = holder.append("circle")
                        .attr("id", "time-scroller")
                        .attr("r", 35)
                        .style("fill", "#BADB73")
                        .style("opacity", 0.1);
                }

*/
                /*var x = d3.scale.linear()
                    .domain([1, 24])
                    .range([30, width - 15]);

                var xAxis = d3.svg.axis()
                    .scale(x)
                    .orient("bottom");

                svg.append("g")
                    .attr("class", "x axis")
                    .attr("transform", "translate(0," + (height - 25) + ")")
                    .call(xAxis);

                var y = d3.scale.linear()
                    .domain([0, 2])
                    .range([5, height - 30]);*/


                function ScaleH(x,start,end){

                  var z = end/24;

                  start = start/z;
                  end = end/z;
                  x = x/z;
                  return x;
                  

                }

                function ScaleD(x,start,end){

                  var z = end/2;

                  start = start/z;
                  end = end/z;
                  x = x/z;
                  return x;
                  

                }

               

               
                    

                 

                /*var yAxis = d3.svg.axis()
                    .scale(y)
                    .orient("left");

                svg.append("g")
                    .attr("class", "y axis")
                    .attr("transform", "translate(21,0)")
                    .call(yAxis);*/

                var link = svg.selectAll(".link")
                    .data(graph.links)
                    .enter().append("line")
                    /*.style("stroke-dasharray", ("1, 1"))*/
                    .attr("name",function(d){ return d.source.name;})
                    .attr("class", "link")
                    .style("stroke-width", "1");

                var node = svg.selectAll(".node")
                    .data(graph.nodes)
                    .enter().append("g")
                    .on('dblclick', function(d) {
                        if (d.Type != "M" && d.Type != "P") {
                            
                            if(d.name != "basic-graph"){
                            UpdateGraph(width, height, r, color, force, svg, "../nodenews/backend/data/" + TimescrollerY + "/" + d.hash + "-data.json",200,TimescrollerY);
                         }else{
                            UpdateGraph(width, height, r, color, force, svg, "../nodenews/backend/data/" + TimescrollerY + "/" + d.name + "-data.json",200,TimescrollerY);
                         }
                        }
                    })
                    .on('click', function(d) {
                        console.log(d);
                    })
                    .call(force.drag);
                node
                    .attr("stroke", function(d) {
                        if (d.name != "main") {
                            return "#f4d03f";
                        }
                    });



                node.append("title")
                    .text(function(d) {
                        if (d.name) {

                            if (d.name == "basic-graph") {
                                return d.Tweet;
                            } else {
                                return d.name;
                            }
                        } else if (d.Tweet) {

                            if (d.Tweet == "Deputy") {
                                return d.UserName;
                            } else {
                                return d.Tweet;
                            }

                        }
                    });

                var label = node.append("text")
                    .text(function(d) {
                        if (d.name == "main") {} else if (d.name != "basic-graph") {
                            return d.name;
                        } else {
                            return d.UserName;
                        }
                    })
                    .attr("font-size", 12)
                    .attr("text-anchor", "middle")
                    .attr("stroke", "none")
                    .attr("fill", "#778899")
                    .attr("font-family", "Roboto");


                var clip = node.append("clipPath")
                    .attr('id', function(d) {
                        return "circle" + d.index
                    })
                    .append('circle')
                    .attr("r", function(d) {
                        size = 30;
                        if (d.size == "big") {
                            return 1.5 * size;
                        } else if (d.size == "normal") {
                            return 1.4 * size;
                        } else if (d.size == "small") {
                            return 1.3 * size;
                        } else if (d.size == "tiny") {
                            return size;
                        }
                    });


                /*var date = svg.append("text")
                            .attr("id","date")
                            .attr("x",width-300)
                            .attr("y",100)
                            .attr("fill","#BADB73")
                            .attr("opacity",0.5)
                            .attr("font-size",40)
                            .text(function(){



                            var hours = Math.round(ScaleH(TimescrollerX,25,width));
                            var days = Math.round(ScaleD(TimescrollerY,40,height-40));
                            
                            var currentdate = new Date();
                            var datetime = (currentdate.getFullYear()) + "-" + ("0" + (currentdate.getMonth() + 1)).slice(-2) + "-" + ("0" + (currentdate.getDate()-days)).slice(-2) + "-" + ("0" + hours).slice(-2);
                            return datetime;


                            }) ;*/



                var imgs = node.append("image")
                    .attr("xlink:href", function(d) {
                        return d.icon;
                    })
                    .attr("id", function(d) {
                        return d.name;
                    })
                    .attr("x", function(d) {

                        if (d.name == "main") {
                            return -(centerImageW / 2);
                        } else {
                            return -(imagesw / 2);
                        }
                    })
                    .attr("y", function(d) {
                        if (d.name == "main") {
                            return -(centerImageH / 2);
                        } else {
                            return -(imagesw / 2);
                        }
                    })
                    .attr("width", function(d) {
                        if (d.name == "main") {
                            return centerImageW;
                        } else {
                            return imagesw;
                        }
                    })
                    .attr("height", function(d) {
                        if (d.name == "main") {
                            return centerImageH;
                        } else {
                            return imagesh;
                        }
                    })
                    .attr("clip-path", function(d) {
                        return "url(#circle" + d.index + ")"
                    });

                var circles = node.append("circle")
                    .attr("class", "node")
                    .attr("r", function(d) {
                        size = 30;
                        if (d.size == "big") {
                            return 1.5 * size;
                        } else if (d.size == "normal") {
                            return 1.4 * size;
                        } else if (d.size == "small") {
                            return 1.3 * size;
                        } else if (d.size == "tiny") {
                            return size;
                        }

                    });



                /*var clippath = node.append("clipPath")
                    .attr("id","circle")
                    .append("circle")
                    .attr("r",40);*/




                force.on("tick", function() {



                    link.attr("x1", function(d) {

                            if(d.source.name == "main"){
                                return d.x = width/2;
                            }else{
                            return d.x = Math.max(r, Math.min(width - r, d.source.x));
                            }
                        })
                        .attr("y1", function(d) {
                            if(d.source.name == "main"){
                                return d.y = height/2;
                            }else{
                            return d.y = Math.max(r, Math.min(height - 2*r, d.source.y));
                            }
                        })
                        .attr("x2", function(d) {
                            return d.x = Math.max(r, Math.min(width - r, d.target.x));
                        })
                        .attr("y2", function(d) {
                            return d.y = Math.max(r, Math.min(height - 2*r, d.target.y));
                        });

                    /*node.attr("cx", function(d) { return d.x; })
                        .attr("cy", function(d) { return d.y; });*/
                    node.attr("cx", function(d) {
                            if(d.name=='main'){
                                return d.x = width/2;
                            }else{
                                return d.x = Math.max(r, Math.min(width - r, d.x));
                            }
                        })
                        .attr("cy", function(d) {
                            if(d.name=='main'){
                                return d.y = height/2;
                            }else{
                               return d.y = Math.max(r, Math.min(height - 2*r, d.y));
                            }
                            
                        });

                    imgs.attr("x", function(d) {
                            if (d.name == "main") {
                                return d.x =width/2 - (centerImageW / 2);
                            } else {
                                return d.x - (imagesw / 2);
                            }
                        })
                        .attr("y", function(d) {
                            if (d.name == "main") {
                                return d.y = height/2 - (centerImageH / 2);
                            } else {
                                return d.y - (imagesh / 2);
                            }
                        })

                    circles.attr("cx", function(d) {
                           if(d.name=='main'){
                                return d.x = width/2;
                            }else{
                               return d.x;
                            }
                        })
                        .attr("cy", function(d) {
                            if(d.name=='main'){
                                return d.y = height/2;
                            }else{
                               return d.y;
                            }
                            
                        });

                    clip.attr("cx", function(d) {
                            if(d.name=='main'){
                                return d.x = width/2;
                            }else{
                               return d.x;
                            }
                        })
                        .attr("cy", function(d) {
                           if(d.name=='main'){
                                return d.y = height/2;
                            }else{
                               return d.y;
                            }
                        });

                    label.attr("x", function(d) {
                            if (d.name) {
                                return d.x;
                            }
                        })
                        .attr("y", function(d) {
                            return d.y + r + r / 2;
                        });

                });
            });
        }