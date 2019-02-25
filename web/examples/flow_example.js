var placeCDMX = {
    latitude: 19.4334004,
    longitude: -99.1344391
}

// Habilitar mapas
// Habilitar API Google Places con autocomplete en textbox
// Habilitar API Google Geocode
// Ocultar componentes
map.init( "div_map" );
geocode.init();
autocomplete.init("flex_buscadireccion_calle");

map.hide();
continueButton.hide();
coverage.hide();

if( localStorage ) localStorage.setItem( "typeProduct", "Flex" );


// Al seleccionar dirección del autocomplete:
// Habilitar arrastre del pin del mapa
autocomplete
    .onSelected( function(){
        var place = autocomplete.getPlace();
        addressComponent.processAddress( place, byMarker = false );    
        
        // Display map
        var 
        lat = addressComponent.getAddress().location.lat, 
        lng = addressComponent.getAddress().location.lng, 
        zoom = 17;

        if(  lat == 0 || lng == 0 )
            alertAddress.show();
        
        else {
            map.centerTo( lat, lng, zoom )                
            map.pinTo( lat, lng );
            map.visible();
            continueButton.show();
            coverage.hide();
            continueFlexButton.hide();
            addressComponent.saveAddress();
        }


    });


// Clic en el boton Buscar cobertura
// del autocomplete
autocomplete.buttonSearch
    .onClick(function(){

        if( autocomplete.isEmpty() )
            alertAddress.show();
        
        else if( map.isVisible() || coverage.isVisible() )
            autocomplete.focus();            

        else
            alertAddress.show();
    });


// Clic en el boton Aceptar del mensaje 
// para modificar dirección
alertAddress.buttonOk
    .onClick(function(){
        if( coverage.isVisible() ){
            autocomplete.focus();
        }
        else if( ! map.isVisible() ){            
            var 
            lat = placeCDMX.latitude, 
            lng = placeCDMX.longitude, 
            zoom = 14;        
            map.centerTo( lat, lng, zoom )                
            map.pinTo( lat, lng );
            map.visible();
        }
        else{
            coverage.hide();
            continueFlexButton.hide();            
        }
        alertAddress.hide();      

    });



// Al arrastrar y soltar el pin del mapa:
// Obtener dirección asociada con el API de Geocodificación inversa
map
    .pinOnDragRelease( function(){
        var pinPos = map.getPin().getPosition();
        geocode
            .getAddressByPinPos( pinPos, function( place ){                    
                addressComponent.processAddress( place, byMarker = true );
                autocomplete.focus();
                continueButton.show();
                addressComponent.saveAddress();
            });
    });





// Continuar para consultar cobertura
continueButton
    .onClick( function(){
        var 
        lat = addressComponent.getAddress().location.lat,
        lng = addressComponent.getAddress().location.lng,
        equipmentType = "All";
        
        recordEvent(kissmetricsEvent.buscarCobertura);
        coverage
            .consultCoverage( lat, lng, equipmentType, function( result ){
                console.log( result.code );
                switch( result.code ){

                    // Si hay cobertura
                    case "RSP_00":
                        
                        // console.log( result.response );
                        coverage.displayProducts( result.response );
                        map.hide();
                        continueButton.hide();
                        coverage.show();
                        continueFlexButton.show();
                        break;

                    // No hay cobertura
                    case "RSP_02":
                        recordEvent(kissmetricsEvent.sinCobertura);
                        location.href = "sin-cobertura.html";                            
                        break;

                    case "ERROR":
                        recordEvent(kissmetricsEvent.coberturaError);
                        console.log("Error al consumir el servicio ");
                        break;
                }

                continueButton.unlock();
            });
    });




// Continuar para contratación 
// Continuar para Flex Plus
continueFlexButton
    .onClick( function(){
        addressComponent.saveFlagAddressComplete();        
        coverage.saveProductChoose();
        recordEvent(kissmetricsEvent.confirmarCobertura);
        
        if( coverage.indexSelectedProduct == coverage.INDEX_FLEX_20 )
            popUpFlexPlus.show();
        else {            

            if( coverage.indexSelectedProduct == coverage.INDEX_FLEX_5 )
                recordEvent(kissmetricsEvent.obtenerFlex5);
            else 
            if( coverage.indexSelectedProduct == coverage.INDEX_FLEX_10 )
                recordEvent(kissmetricsEvent.obtenerFlex10);

            window.location.href = "eleccion-cuenta.html";
        }            
    });



// Continuar para Flex 20 
popUpFlexPlus.buttonFlex20
    .onClick(function(){
        recordEvent(kissmetricsEvent.obtenerFlex20);
        window.location.href = "eleccion-cuenta.html";
    });


// Continuar para Flex 20 Plus
popUpFlexPlus.buttonFlex20Plus
    .onClick(function(){

        coverage.indexSelectedProduct = coverage.INDEX_FLEX_20_PLUS;
        coverage.saveProductChoose();
        window.location.href = "eleccion-cuenta.html";        
    });