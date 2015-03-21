function initialize() {
    var e, t = [{
            featureType: "all",
            stylers: [{
                saturation: -100
            }, {
                gamma: .5
            }]
        }],
        s = [{
            featureType: "all",
            stylers: [{
                hue: "#0000b0"
            }, {
                invert_lightness: "true"
            }, {
                saturation: -30
            }]
        }],
        i = [{
            featureType: "all",
            stylers: [{
                hue: "#ff1a00"
            }, {
                invert_lightness: !0
            }, {
                saturation: -100
            }, {
                lightness: 33
            }, {
                gamma: .5
            }]
        }],
        a = [{
            stylers: [{
                hue: "#ff61a6"
            }, {
                visibility: "on"
            }, {
                invert_lightness: !0
            }, {
                saturation: 40
            }, {
                lightness: 10
            }]
        }],
        l = [{
            featureType: "water",
            elementType: "all",
            stylers: [{
                hue: "#e9ebed"
            }, {
                saturation: -78
            }, {
                lightness: 67
            }, {
                visibility: "simplified"
            }]
        }, {
            featureType: "landscape",
            elementType: "all",
            stylers: [{
                hue: "#ffffff"
            }, {
                saturation: -100
            }, {
                lightness: 100
            }, {
                visibility: "simplified"
            }]
        }, {
            featureType: "road",
            elementType: "geometry",
            stylers: [{
                hue: "#bbc0c4"
            }, {
                saturation: -93
            }, {
                lightness: 31
            }, {
                visibility: "simplified"
            }]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [{
                hue: "#ffffff"
            }, {
                saturation: -100
            }, {
                lightness: 100
            }, {
                visibility: "off"
            }]
        }, {
            featureType: "road.local",
            elementType: "geometry",
            stylers: [{
                hue: "#e9ebed"
            }, {
                saturation: -90
            }, {
                lightness: -8
            }, {
                visibility: "simplified"
            }]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [{
                hue: "#e9ebed"
            }, {
                saturation: 10
            }, {
                lightness: 69
            }, {
                visibility: "on"
            }]
        }, {
            featureType: "administrative.locality",
            elementType: "all",
            stylers: [{
                hue: "#2c2e33"
            }, {
                saturation: 7
            }, {
                lightness: 19
            }, {
                visibility: "on"
            }]
        }, {
            featureType: "road",
            elementType: "labels",
            stylers: [{
                hue: "#bbc0c4"
            }, {
                saturation: -93
            }, {
                lightness: 31
            }, {
                visibility: "on"
            }]
        }, {
            featureType: "road.arterial",
            elementType: "labels",
            stylers: [{
                hue: "#bbc0c4"
            }, {
                saturation: -93
            }, {
                lightness: -2
            }, {
                visibility: "simplified"
            }]
        }],
        r = [{
            featureType: "landscape.natural",
            elementType: "geometry.fill",
            stylers: [{
                visibility: "on"
            }, {
                color: "#e0efef"
            }]
        }, {
            featureType: "poi",
            elementType: "geometry.fill",
            stylers: [{
                visibility: "on"
            }, {
                hue: "#1900ff"
            }, {
                color: "#c0e8e8"
            }]
        }, {
            featureType: "landscape.man_made",
            elementType: "geometry.fill"
        }, {
            featureType: "road",
            elementType: "geometry",
            stylers: [{
                lightness: 100
            }, {
                visibility: "simplified"
            }]
        }, {
            featureType: "road",
            elementType: "labels",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "water",
            stylers: [{
                color: "#7dcdcd"
            }]
        }, {
            featureType: "transit.line",
            elementType: "geometry",
            stylers: [{
                visibility: "on"
            }, {
                lightness: 700
            }]
        }],
        y = [{
            featureType: "landscape",
            stylers: [{
                hue: "#F1FF00"
            }, {
                saturation: -27.4
            }, {
                lightness: 9.4
            }, {
                gamma: 1
            }]
        }, {
            featureType: "road.highway",
            stylers: [{
                hue: "#0099FF"
            }, {
                saturation: -20
            }, {
                lightness: 36.4
            }, {
                gamma: 1
            }]
        }, {
            featureType: "road.arterial",
            stylers: [{
                hue: "#00FF4F"
            }, {
                saturation: 0
            }, {
                lightness: 0
            }, {
                gamma: 1
            }]
        }, {
            featureType: "road.local",
            stylers: [{
                hue: "#FFB300"
            }, {
                saturation: -38
            }, {
                lightness: 11.2
            }, {
                gamma: 1
            }]
        }, {
            featureType: "water",
            stylers: [{
                hue: "#00B6FF"
            }, {
                saturation: 4.2
            }, {
                lightness: -63.4
            }, {
                gamma: 1
            }]
        }, {
            featureType: "poi",
            stylers: [{
                hue: "#9FFF00"
            }, {
                saturation: 0
            }, {
                lightness: 0
            }, {
                gamma: 1
            }]
        }],
        o = [{
            featureType: "administrative",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "poi",
            stylers: [{
                visibility: "simplified"
            }]
        }, {
            featureType: "road",
            elementType: "labels",
            stylers: [{
                visibility: "simplified"
            }]
        }, {
            featureType: "water",
            stylers: [{
                visibility: "simplified"
            }]
        }, {
            featureType: "transit",
            stylers: [{
                visibility: "simplified"
            }]
        }, {
            featureType: "landscape",
            stylers: [{
                visibility: "simplified"
            }]
        }, {
            featureType: "road.highway",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "road.local",
            stylers: [{
                visibility: "on"
            }]
        }, {
            featureType: "road.highway",
            elementType: "geometry",
            stylers: [{
                visibility: "on"
            }]
        }, {
            featureType: "water",
            stylers: [{
                color: "#84afa3"
            }, {
                lightness: 52
            }]
        }, {
            stylers: [{
                saturation: -17
            }, {
                gamma: .36
            }]
        }, {
            featureType: "transit.line",
            elementType: "geometry",
            stylers: [{
                color: "#3f518c"
            }]
        }],
        n = [{
            featureType: "all",
            elementType: "all",
            stylers: [{
                invert_lightness: !0
            }, {
                saturation: 10
            }, {
                lightness: 30
            }, {
                gamma: .5
            }, {
                hue: "#435158"
            }]
        }],
        p = [{
            stylers: [{
                hue: "#ff8800"
            }, {
                gamma: .4
            }]
        }],
        u = jQuery(document).width() > 480 ? !0 : !1;
    switch (WILOKE_GOOGLEMAP.theme) {
        case "grayscale":
            e = t;
            break;
        case "blue":
            e = s;
            break;
        case "dark":
            e = i;
            break;
        case "pink":
            e = a;
            break;
        case "light":
            e = l;
            break;
        case "blue-essence":
            e = r;
            break;
        case "bentley":
            e = y;
            break;
        case "retro":
            e = o;
            break;
        case "cobalt":
            e = n;
            break;
        case "brownie":
            e = p;
            break;
        default:
            e = t
    } {
        var f = new google.maps.LatLng(WILOKE_GOOGLEMAP.lat, WILOKE_GOOGLEMAP["long"]),
            m = {
                zoom: 14,
                center: f,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.DEFAULT
                },
                draggable: u,
                scrollwheel: !1,
                overviewMapControlOptions: {
                    opened: !1
                },
                styles: e,
                mapTypeId: google.maps.MapTypeId[WILOKE_GOOGLEMAP.type],
                overviewMapControl: !0,
                streetViewControl: !0,
                panControl: !0,
                scaleControl: !0,
                disableDoubleClickZoom: !0,
                zoomControl: !0
            },
            g = new google.maps.Map(document.getElementById("map"), m);
        var _marker = piImgs + 'marker.png';
        new google.maps.Marker({
            position: f,
            map: g,
            icon: _marker
        })
    }
}