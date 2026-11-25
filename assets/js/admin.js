jQuery(function($){

    // Settings - color

    if($(".wmacs-settings-field").length){
        $(".wmacs-settings-field.-color input").spectrum({
            preferredFormat: "hex",
            showInput: true,
            showPalette: true,
            palette: [[
                "White", "Silver", "Gray", "Black", "Red", "Maroon", "Yellow", "Olive",
                "Lime", "Green", "Aqua", "Teal", "Blue", "Navy", "Fuchsia", "Purple",
            ]],
        });
    }

});