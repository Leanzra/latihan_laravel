$(document).ready(function() {
    var root = window.location.origin + '/pembayaran_listrik/';

    var options = {
        url: function(phrase) {
            return root + 'pelanggan/ajaxIndex';
        },
        getValue: function(element) {
            return element.id_pelanggan + ' - ' + element.nama + ' - ' + element.no_meter;
        },
        ajaxSettings: {
            dataType: "json",
            method: "GET",
            success: function(data) {
                console.log('Data received for autocomplete:', data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error in autocomplete AJAX request:', textStatus, errorThrown);
            }
        },
        adjustWidth: false,
        list: {
            sort: {
                enabled: true
            },
            showAnimation: {
                type: "fade",
                time: 400,
                callback: function() {}
            },
            hideAnimation: {
                type: "slide",
                time: 400,
                callback: function() {}
            },
            match: {
                enabled: true
            },
            onSelectItemEvent: function() {
                var selectedItemData = $('#nama_pelanggan').getSelectedItemData();
                if (selectedItemData) {
                    $('#id_pelanggan').val(selectedItemData.id_pelanggan).trigger('change');
                    $('#id_tarif').val(selectedItemData.id_tarif).trigger('change');
                }
            }
        }
    };

    $('#nama_pelanggan').easyAutocomplete(options);

    // Example: Debugging and checking for AJAX errors separately
    $.ajax({
        url: root + 'pelanggan/ajaxIndex',
        method: 'GET',
        success: function(data) {
            console.log('Data loaded successfully:', data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error loading data:', textStatus, errorThrown);
        }
    });
});
