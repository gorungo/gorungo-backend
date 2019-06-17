<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Gorungo - есть чем заняться</title>
    <style>
        html,body{
            height:100%;
            padding:0;
            margin:0;
            color: #a7a7a7;
            background-color: #343a40;
        }
        *{
            box-sizing:border-box;
        }
        .logo-placer{
            text-align: center;
            width:300px;
        }
        .logo-placer img{
            width:300px;
        }

        canvas{
            display: block;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 0;
        }

        .mountains-blue {
            background-image: url(/images/bg/mountains_blue.svg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .container{

            width:100%;
            height:100%;

            display:flex;
            justify-content:center;
            align-items:center;

        }
    </style>
</head>
<body>
<div class="mountains-blue">
    <div class="container">
        <div class="logo-placer" id="prestart">
            <img class="logo"  src="/images/interface/logo/main_logo.svg" alt="gorungo logo"/>
            <p>Coming soon</p>
        </div>
    </div>
</div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    particlesJS("prestart", {
        "particles": {
            "number": {
                "value": 100,
                "density": {
                    "enable": true,
                    "value_area": 789.1476416322727
                }
            },
            "color": {
                "value": "#ffffff"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 0.48927153781200905,
                "random": false,
                "anim": {
                    "enable": true,
                    "speed": 0.2,
                    "opacity_min": 0,
                    "sync": false
                }
            },
            "size": {
                "value": 2,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 2,
                    "size_min": 0,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": false,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 0.2,
                "direction": "none",
                "random": true,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "bubble"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 83.91608391608392,
                    "size": 1,
                    "duration": 3,
                    "opacity": 1,
                    "speed": 3
                },
                "repulse": {
                    "distance": 200,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
</script>

