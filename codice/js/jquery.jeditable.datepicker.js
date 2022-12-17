$j.editable.addInputType('datepicker', {
    element : function(settings, original) {
        var input = $j('<input/>');
        
        if (settings.width  != 'none') { input.width(settings.width);  }
        if (settings.height != 'none') { input.height(settings.height); }
        input.attr('autocomplete','off');
        $j(this).append(input);
        return(input);
    },
    plugin : function(settings, original) {
        /* Workaround for missing parentNode in IE */
        var form = this;
        settings.onblur = 'ignore';
        $j(this).find('input').datepicker(
	        {
    	    	firstDay: 1,
        		dateFormat: 'dd/mm/yy',
        		closeText: 'X'        		
    		}
        ).bind('click', function() {
                
                $j(this).datepicker('show');
                $j(this).datepicker('option', $j.datepicker.regional[ "it" ]);
	          return false;
        }).bind('dateSelected', function(e, selectedDate, $td) {
            $j(form).submit();
        });
    }
});
