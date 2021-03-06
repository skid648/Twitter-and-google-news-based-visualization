


        var width = window.innerWidth - 20;
        var height = window.innerHeight - 200;
        imagesw = 130;
        imagesh = 130;
        centerImageW = 70;
        centerImageH = 70;
        if(width <800){
             var r = 20;
             width = width+20;
             linkdistance = height/10;
             height = width*2;
        }else{
             var r = 30;
             linkdistance = height/5;
        }


       

        var color = d3.scale.category20();

        var force = d3.layout.force()
            .charge(-2500)
            .linkDistance(linkdistance)
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

        $('#refresh').click(function(){
            UpdateGraph(width, height, r, color, force, svg, jsonfile,640,datetime);
        });

        function UpdateGraph(width, height, r, color, force, svg, json,TimescrollerX,TimescrollerY) {

            date = jsonfile.split("/");
                            date = date[3];
                            

            svg.selectAll("*").remove();



            d3.json(json, function(error, graph) {
                force
                    .nodes(graph.nodes)
                    .links(graph.links)
                    .start();

               

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

               
                svg.on("touchend", function(d) {
                        
                        $(".tweet").animate({
                                right:"-250px",



                            });

                    });
                    
                var link = svg.selectAll(".link")
                    .data(graph.links)
                    .enter().append("line")
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
                    .on("touchend", function(d) {
                        
                        if (d.Type != "M" && d.Type != "P") {
                            
                            if(d.name != "basic-graph"){
                            UpdateGraph(width, height, r, color, force, svg, "../nodenews/backend/data/" + TimescrollerY + "/" + d.hash + "-data.json",200,TimescrollerY);
                         }else{
                            //UpdateGraph(width, height, r, color, force, svg, "../nodenews/backend/data/" + TimescrollerY + "/" + d.name + "-data.json",200,TimescrollerY);
                         }
                        }
                    })
                    .on('click', function(d) {
                        console.log(d);
                        $(".tweet").removeClass('rotatetweet');
                    })
                    .on("mouseenter",function(d){
                        if(d.Tweet != "Deputy" && d.name == "basic-graph"){
                            $("img#img").attr("src",d.icon);
                            $(".tweet > #tweet_body > #info > #name").text(d.UserName);
                            $(".tweet > #tweet_body > #info > #screen_name").text("@"+d.ScreenName);
                            $(".tweet > #tweet_body > #tweet_text").text(d.Tweet);
                            var d = new Date(d.Date);
                            date = "at "+ d.getHours() + ":" +('0'+d.getMinutes()).slice(-2);
                            document.getElementById("date").innerHTML = date;
                            $(".tweet").addClass('rotatetweet');

                        }
                    })
                    .on("touchstart",function(d){
                        if(d.Tweet != "Deputy" && d.name == "basic-graph"){
                            $("img#img").attr("src",d.icon);
                            $(".tweet > #tweet_body > #info > #name").text(d.UserName);
                            $(".tweet > #tweet_body > #info > #screen_name").text("@"+d.ScreenName);
                            $(".tweet > #tweet_body > #tweet_text").text(d.Tweet);
                            var d = new Date(d.Date);
                            date = "at "+ d.getHours() + ":" +('0'+d.getMinutes()).slice(-2);
                            document.getElementById("date").innerHTML = date;
                            //$(".tweet").addClass('rotatetweetmobile');
                            console.log($('tweet_body').css('display'));
                            if($('#tweet_body').css('display') == 'none'){
                                if(width<800){
                                    $('#tweet_body').slideToggle();
                                    
                                }
                            


                        }
                    }else{
                                if(width<800){
                                    if(d.Tweet == "Deputy"){
                                        alert("e");
                                        $('#tweet_body').slideToggle();
                                    }
                                }
                            }


                    })
                    .on("mouseout",function(d){
                         if(d.Tweet != "Deputy" && d.name == "basic-graph"){
                             $(".tweet").removeClass('rotatetweet');

                        }
                    })

                    .call(force.drag);
                node
                    .attr("stroke", function(d) {
                        if (d.name != "main") {
                            return "#81C7BC";
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
                    .attr("fill", "#2A3640")
                    .attr("font-family", "Roboto");


                var clip = node.append("clipPath")
                    .attr('id', function(d) {
                        return "circle" + d.index
                    })
                    .append('circle')
                    .attr("r", function(d) {
                        size = r;
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




                var imgs = node.append("image")
                    .attr("xlink:href", function(d) {
                        return d.icon.replace("_normal","");
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
                        size = r;
                        if (d.size == "big") {
                            return 1.5 * size;
                        } else if (d.size == "normal") {
                            return 1.4 * size;
                        } else if (d.size == "small") {
                            return 1.3 * size;
                        } else if (d.size == "tiny") {
                            return size;
                        }

                    })
                    .style("stroke",function(d){
                        if(d.size == "big"){
                            return "none";
                        }
                    });



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

                                return d.y + r + r;
                               
                            
                        });

                });
            });
        }

        if(width<800){
            $('#tweet_body').slideToggle();
            
        }
        


       