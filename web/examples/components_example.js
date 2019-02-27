var URL_CONSULTAR_COBERTURA = env.serverURL + "/coverage/getCoverage/?latitud={lat}&longitud={lng}&equipmentType={equipmentType}";

var autocomplete = new Vue({
   el: '#autocomplete-component',
   data: {
        googleAutocomplete: null,
        div:"",
        buttonSearch:{
            callBack:null,
            onClick:function( callBack ){
                this.callBack = callBack; 
            },
            
        },
   },

   created: function() {},
   methods: {
        init:function( div ){
            this.googleAutocomplete = 
                new google.maps.places.Autocomplete( document.getElementById( div ));
            this.googleAutocomplete.setComponentRestrictions({
                'country': ['mx']
            });
            this.div = div;
        },
        onSelected:function( callBack ){
            google.maps.event.addListener( this.googleAutocomplete, 'place_changed', callBack );            
        },
        getPlace:function(){
            // var location = this.googleAutocomplete.getPlace().geometry.location;
            return this.googleAutocomplete.getPlace();
        },
        getAddress:function(){
            var location = this.googleAutocomplete.getPlace().geometry.location;
            var place = this.googleAutocomplete.getPlace();

            addressProcessor.init( place );
            var address = addressProcessor.getAddress( byMarker = true );
            addressComponent.setAddress( address );          
            return {
                location:{
                    lat:location.lat(),
                    lng:location.lng(),
                }
            };
        },
        setAddress:function( address ){
        },
        buttonSearchOnClickListener:function( ev ){
            if ( ev ) ev.preventDefault();
            this.buttonSearch.callBack();
        },
        focus:function(){
            $( "#"+this.div ).focus();
        },
        isEmpty:function(){
            var val = $( "#"+this.div ).val().trim();            
            return val == "";
        }
   }
});


var map  = new Vue({
    el: '#map-component',
    store,
    data: {
        visibility: true,
        googleMap: null,
        marker:null,
        markers:[],
        pinOnDragReleaseCallBack:null,
        styles:[{elementType:"geometry",stylers:[{color:"#f1f3f5"}]},{elementType:"labels.icon",stylers:[{visibility:"off"}]},{elementType:"labels.text.fill",stylers:[{color:"#8d9fbb"}]},{elementType:"labels.text.stroke",stylers:[{color:"#f5f5f5"}]},{featureType:"administrative.land_parcel",elementType:"labels.text.fill",stylers:[{color:"#bdbdbd"}]},{featureType:"landscape.natural",elementType:"geometry",stylers:[{color:"#d4f1c9"}]},{featureType:"poi",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"poi.park",elementType:"geometry.fill",stylers:[{color:"#d4f1c9"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#ffffff"}]},{featureType:"road.arterial",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#c7cdda"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{featureType:"road.local",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"transit.line",elementType:"geometry",stylers:[{color:"#e5e5e5"}]},{featureType:"transit.station",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#c9c9c9"}]},{featureType:"water",elementType:"geometry.fill",stylers:[{color:"#a5cbe3"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]}],
    },
   
    created: function() {},
    methods: {
        init:function( div ){
            this.googleMap = new google.maps.Map(document.getElementById( div ), {
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: this.styles,
                disableDefaultUI: true,
                zoomControl: true,
            });
        },
        centerTo: function( lat, lng, zoom ) {
            if( this.googleMap != null && lat != 0 && lng!= 0 ){                
                this.googleMap.setCenter( new google.maps.LatLng( lat, lng ) );
                this.googleMap.setZoom( zoom );
            }
        },
        pinTo: function( lat, lng ) {
            if( this.googleMap != null && lat != 0 && lng!= 0 ){ 
                this.clearMarkers();
                var marker = new google.maps.Marker({
                    position:  new google.maps.LatLng( lat, lng ),
                    draggable: true
                });
                
            
                marker.setMap( this.googleMap );
                this.markers.push( marker );
                this.marker = marker;

                // Add dragging event listeners.
                if( this.pinOnDragReleaseCallBack )
                    google.maps.event.addListener(this.marker, 'dragend', this.pinOnDragReleaseCallBack );
            }

        },
        clearMarkers:function(){
            for (var i in this.markers ) 
                this.markers[i].setMap( null );     
        },
        pinInitDrag:function(){
            alert("pinInitDrag")
        },
        pinOnDragRelease:function( callBack ){
            this.pinOnDragReleaseCallBack = callBack;            
        },
        getPin:function(){
            var location = this.marker.getPosition();            
            return {
                getLatitude: function(){ return location.lat(); },
                getLongitude: function(){ return location.lng(); },
                getPosition: function(){ return location; }
            };
        },
        hide:function(){
            this.visibility = false;
        },
        visible:function(){
            this.visibility = true;
        },
        isVisible:function(){
            return this.visibility;
        }

    }
});


var continueButton = new Vue({
    el: '#continue-component',    
    data: {
        visibility:true,
        flag:{
            block:false
        },
        label:{
            text:'Continuar',
            reset:'Continuar',
            block:'Validando...'
        },
        onClickCallBack:null    
    },
    methods: {
        hide:function(){
            this.visibility = false;
        },        
        show:function(){
            this.visibility = true;
        },
        block:function(){
            if( !this.flag.block ){                
                this.label.text = this.label.block;
                return this.flag.block = true;
            }
            return false;
        },
        unlock:function(){
            this.label.text = this.label.reset;
            this.flag.block = false;
        },
        onClick:function( callBack ){
            this.onClickCallBack = callBack;
        },
        onClickListener: function( ev ){
            if ( ev ) ev.preventDefault();
            if( ev.screenX == 0 && ev.screenY == 0 || 
                ev.clientX == 0 && ev.clientY == 0 
                )
                return;

            if( this.block() ){
                this.onClickCallBack( ev );
            }
        }
        
    }
});


var continueFlexButton = new Vue({
    el: '#continue-flex-component',    
    data: {
        visibility:false,
        flag:{
            block:false
        },
        label:{
            text:'Continuar',
            reset:'Continuar',
            block:'Redireccionando ...'
        },
        onClickCallBack:null     
    },
    created: function() {},
    methods: {
        init:function( callBack ){
            callBack();
        },
        hide:function(){
            this.visibility = false;
        },        
        show:function(){
            this.visibility = true;
        },
        block:function(){
            if( !this.flag.block ){                
                this.label.text = this.label.block;
                return this.flag.block = true;
            }
            return false;
        },
        unlock:function(){
            this.label.text = this.label.reset;
            this.flag.block = false;
        },
        onClick:function( callBack ){
            this.onClickCallBack = callBack;
        },
        onClickListener: function( ev ){
            if ( ev ) ev.preventDefault();
            if( this.block() ){
                this.onClickCallBack();                
                this.unlock();
            }
        },        
    }
});




var coverage = new Vue({
    el: '#coverage-component',
    store,   
    data: {
        INDEX_FLEX_5:0,
        INDEX_FLEX_10:1,
        INDEX_FLEX_20:2,
        INDEX_FLEX_20_PLUS:3,
        visibility:true,
        response:null,
        indexSelectedProduct:2,
        products:[]   
    },
    created: function() {},
    methods: {
        init:function( callBack ){
            callBack();
        },
        hide:function(){
            this.visibility = false;
        },
        consultCoverage:function( lat, lng, equipmentType, callBack ){
            var URL = 
                URL_CONSULTAR_COBERTURA
                    .replace("{lat}", lat )
                    .replace("{lng}", lng )
                    .replace("{equipmentType}", equipmentType )
                    ;
            console.log( URL );
            // Consulta de cobertura    
            axios({
                "method": "GET",
                "url": URL,
                "Accept": "*/*"
            }, ).then(
            result => {                
                callBack( result.data );
            }, 
            error => {                
                console.error(error);
                callBack( { "code": "ERROR" } );
                
            });
            // setTimeout(callBack,1000);
        },        
        saveProductChoose:function(){

            var index = this.indexSelectedProduct;                
            this.$store.dispatch("toggleProduct", {
                price: this.products[ index ].regularProductCost,
                velocity: this.products[ index ].productMB,
                description: this.products[ index ].productDescription,
                type: this.products[ index ].keySpeed,
                firstProductCost: this.products[ index ].firstProductCost,
                productName: this.products[ index ].productName
            });
        },
        displayProducts:function( products ){
            // Por default carga el paquete mas alto.
            // Si hay Flex 20 Plus lo ignora
            if( products[ this.INDEX_FLEX_20_PLUS ] )          
                this.indexSelectedProduct = products.length - 2; 
            else
                this.indexSelectedProduct = products.length - 1; 

            this.products = products;
        },
        generateSpeedParameters:function( list ){
            var str = "";
            for (var i in list) {
                var productId = list[i].productId;
                var productValue = list[i].productValue;
                if (productId != "SERVICE_PROVIDER"){

                    if( ( productId == "SPEED_1" && productValue == "F5M" )     ||
                        ( productId == "SPEED_2" && productValue == "F10M" )    ||
                        ( productId == "SPEED_3" && productValue == "F20M" ) 
                        )
                        str += productId + ","
                }
            }
            return {
                "keySpeeds": str
            };
        },
        show:function(){
            this.visibility = true;
        },
        isVisible:function(){
            return this.visibility;
        }
    }
});

var addressComponent = new Vue({
    el: '#address-component',
    store,
    data: {
        flagAddressComplete:false,
        address:{
            location:{
                lat:0.0,
                lng:0.0
            }
        }
    },
    created: function() {},
    methods: {
        setAddress:function( address ){
            // if( address.location )
            //     this.address.location = address.location;
            this.address = address;
            this.flagAddressComplete = !address.addressIncomplete;
        },
        getAddress:function(){
            return this.address;
        },
        save:function(){
            // alert("save")
        },
        setflagAddressComplete:function( flag ){
            this.flagAddressComplete = flag;
        },
        saveFlagAddressComplete:function(){
            if( localStorage )
                localStorage.setItem( "flagAddressComplete", this.flagAddressComplete );
        },
        processAddress:function( place, byMarker ){
            // Habilitar procesador de direcciones
            // --
            addressProcessor.init( place );
            var address = addressProcessor.getAddress( byMarker );
            addressComponent.setAddress( address );
        },
        saveAddress:function(){

            var address = this.address;
            this.$store.dispatch("addLeadAddress", {
                street: address.street,
                streetNumber: address.streetNumber,
                colony: address.colony,
                city: address.city,
                state: address.state,
                zipCode: address.zip,
                latitude: address.location.lat,
                longitude: address.location.lng,
                formattedAddress: address.formatted_address
            });
        }
    }  
});


var geocode = new Vue({
    el: '',
    data: {
        googleGeocode: null,
    },

    created: function() {},
    methods: {
        init:function(){
            this.googleGeocode = new google.maps.Geocoder();
        },
        getAddress:function( lat, lng ){
            
        },
        getAddressByPinPos:function( pinPos, callBack ){

            this.googleGeocode.geocode({
                latLng: pinPos
            }, function( responses ) {
                if ( responses && responses.length > 0 ) {

                //Actualiza calle y codigo postal.    
                    callBack( responses[0] );
                }
            });
            
        }
    }
});


var addressProcessor = new Vue({
    el: '',
    data: {
        place: null,
        address:{
            location:{
                lat:0,
                lng:0
            },
            addressIncomplete:true
        },
    },

    created: function() {},
    methods: {
        init: function( place ){
            this.place = place;
        },
        findBy:function( str,  list ){
                        
            return (str == undefined) ?
                (function(str, words) {
                    for (var i in words) {
                        var word = words[i];
                        var res = (function(str, word) {
                            str = str.toLowerCase();
                            var list = str.split(",");
                            for (var i in list)
                                if (list[i].indexOf(word) != -1)
                                    return list[i].trim().substring(0, 23);
                        })(str, word);
                        if (res != undefined)
                            return res;
                    }
                })(place.formatted_address, list ) : str;
        },
        getAddress:function( byMarker ){

            var place = this.place;
            var address = place.address_components;
            var street, streetNumber, colony, city, state, zip, addressIncomplete = false;
            if( place.geometry ){
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();                
            }
            else
                return this.address;

            address.forEach(function(component) {
                var types = component.types;
                if (types.indexOf('route') > -1) {
                    street = component.long_name;
                }
                if (types.indexOf('street_number') > -1) {
                    streetNumber = component.long_name;
                }
                if (types.indexOf('sublocality_level_1') > -1) {
                    colony = component.long_name;
                }
                if (types.indexOf('locality') > -1) {
                    city = component.long_name;
                }
                if (types.indexOf('administrative_area_level_1') > -1) {
                    state = component.long_name;
                }
                if (types.indexOf('postal_code') > -1) {
                    zip = component.long_name;
                }
            });



            var findBy = ["lote", "manzana", "casa"];
            streetNumber = (streetNumber == undefined) ?
                (function(str, words) {
                    for (var i in words) {
                        var word = words[i];
                        var res = (function(str, word) {
                            str = str.toLowerCase();
                            var list = str.split(",");
                            for (var i in list)
                                if (list[i].indexOf(word) != -1)
                                    return list[i].trim().substring(0, 23);
                        })(str, word);
                        if (res != undefined)
                            return res;
                    }
                })(place.formatted_address, findBy) : streetNumber;

            findBy = ["unnamed", "road", "calle"];
            street = (street == undefined) ?
                (function(str, words) {
                    for (var i in words) {
                        var word = words[i];
                        var res = (function(str, word) {
                            var reset = str;
                            str = str.toLowerCase();
                            var list = str.split(",");
                            var lReset = reset.split(",");
                            for (var i in list)
                                if (list[i].indexOf(word) != -1)
                                    return lReset[i].trim();
                        })(str, word);
                        if (res != undefined)
                            return res;
                    }
                })(place.formatted_address, findBy) : street;

                if (streetNumber == undefined && !byMarker) {
                    if (streetNumber == undefined) {
                        var list = $("#flex_buscadireccion_calle").val().split(" ");

                        for (var i in list) {
                            var ref = list[i];
                            var n = parseInt(ref);
                            if (Number.isInteger(n) && ref.length <= 3) {
                                streetNumber = n;
                                break;
                            }
                        }
                    }
                }

                if ($("label[name=temp-err]").length) {
                    $("#flex_buscadireccion_calle").parent().removeClass("error");
                    $("label[name=temp-err]").remove();
                }

                if (street != undefined)
                    street = (street.toLowerCase() == "unamed road" || street == "Unnamed Road") ? "Calle sin nombre" : street;



            var _formatted_address = clear(street) + putCommaTwo(street,streetNumber) + clear(streetNumber) + putCommaTwo(streetNumber,colony) + clear(colony) + putCommaTwo(colony, state) + clear(state) + putCommaTwo(state,zip) + clear(zip);


            if (street != undefined) {
                $("#flex_buscadireccion_calle").val(_formatted_address);
            } else if (byMarker)
                if (streetNumber != undefined) {
                    $("#flex_buscadireccion_calle").val(_formatted_address);
                }
            else
                $("#flex_buscadireccion_calle").val(place.formatted_address);
            else {
                $("#flex_buscadireccion_calle").val(_formatted_address);
            }

            if ( street == undefined || street == null ||
                streetNumber == undefined || streetNumber == null) {

                addressIncomplete = true;

            } else {
                $("#flex_buscadireccion_calle").parent().removeClass("error");
                $("label[name=temp-err]").remove();
            }

            this.address = {
                        street:street,
                        streetNumber:streetNumber,
                        colony:colony,
                        city:city,
                        state:state,
                        zip:zip,
                        formatted_address:_formatted_address,
                        location:{
                            lat: lat,
                            lng: lng
                        },
                        addressIncomplete: addressIncomplete
                    };
            return this.address;
        }
    }
});




var popUpFlexPlus = new Vue({
    data:{
        buttonFlex20:{
            flag:{
                block:false
            },
            label:{
                text:'Quiero flex 20',
                reset:'Quiero flex 20',
                block:'Validando ...'
            },
            callBack:null,
            onClick:function( callBack ){
                this.callBack = callBack; 
            },
            block:function(){
                if( !this.flag.block ){                
                    this.label.text = this.label.block;
                    return this.flag.block = true;
                }
                return false;
            },
            unlock:function(){
                this.label.text = this.label.reset;
                this.flag.block = false;
            },
        },
        buttonFlex20Plus:{
            flag:{
                block:false
            },
            label:{
                text:'Quiero flex 20 plus',
                reset:'Quiero flex 20 plus',
                block:'Validando ...'
            },
            callBack:null,
            onClick:function( callBack ){
                this.callBack = callBack; 
            },
            block:function(){
                if( !this.flag.block ){
                    this.label.text = this.label.block;
                    return this.flag.block = true;
                }
                return false;
            },
            unlock:function(){
                this.label.text = this.label.reset;
                this.flag.block = false;
            },
        },
    },
    el: '#popup-flex-plus-component',
    methods:{
        show:function(){
            this.$refs.popup_flex_plus.click();
        },
        buttonFlex20onClickListener:function( ev ){
            if ( ev ) ev.preventDefault();
            if( this.buttonFlex20.block() ){
                this.buttonFlex20.callBack();                
                this.buttonFlex20.unlock();
            }
        },
        buttonFlex20PlusonClickListener:function( ev ){
            if ( ev ) ev.preventDefault();
            if( this.buttonFlex20Plus.block() ){
                this.buttonFlex20Plus.callBack();                
                this.buttonFlex20Plus.unlock();
            }
        }
    }
});





var alertAddress = new Vue({
    el: '#alert-address-component',
    data:{
        buttonOk:{
            flag:{
                block:false
            },
            label:{
                text:'Aceptar',
                reset:'Aceptar',
                block:'Validando ...'
            },
            callBack:null,
            onClick:function( callBack ){
                this.callBack = callBack; 
            },
            block:function(){
                if( !this.flag.block ){                
                    this.label.text = this.label.block;
                    return this.flag.block = true;
                }
                return false;
            },
            unlock:function(){
                this.label.text = this.label.reset;
                this.flag.block = false;
            },
        },

    },
    methods:{
        show:function(){
            this.$refs.alert_address_show.click();
        },
        hide:function(){
            this.$refs.alert_address_hide.click();
        },
        buttonOkOnClickListener:function( ev ){
            if ( ev ) ev.preventDefault();       
            this.buttonOk.callBack();
        }
    }
});