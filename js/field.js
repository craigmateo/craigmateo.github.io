var activeID;
var activeDrag;
var idmax;
var target;


$(".math-field").click(function(){
    $('.mq-editable-field').each(function(){
        if($( this ).hasClass('mq-focused') ) {
            activeID =  $( this ).attr('id');
            target = activeID.replace("math-field","dragdiv")
        }
  });
});


/* On keyup: get active element */
$(document).keyup(function(event) {
    let max = 0;
    $('.mq-editable-field').each(function(){
        if($( this ).hasClass('mq-focused') ) {
            activeID =  $( this ).attr('id');
        }
    });

    totalFields = max;

    /* DELETE: Delete active math-field */
    if(event.which === 46) {
        $( "#"+activeID ).remove();
        $( "#" + activeID.replace("math-field","dragdiv") ).remove();
        $( "#" + activeID.replace("math-field","latex") ).remove();
        
    
    }

    /* ENTER: Create new math-field below active element */
    else if (event.which == 13) {
        createField();
    }

});

/* click fraction button */
$("#fraction").click(function(){
    let count=0;
    $('.mq-editable-field').each(function(){
        count++;
    });
    if (count>0) {

        $('.mq-editable-field').each(function(){
            if($( this ).hasClass('mq-focused') ) {
                activeID =  $( this ).attr('id');
            }
        });

        if (typeof activeID != 'undefined') {
            // write to last position of cursor
            let mathFieldSpan = document.getElementById(activeID);
            var mathField = MQ.MathField(mathFieldSpan);
            mathField.write('\\frac{a}{b}');
        }
    }
    
    else {
        createField();
        focus();
    }
  });

  /* cursor focus active element */
    function focus() {
        var activeField = activeID.replace("math-field","mathField");
        window[activeField].focus();
    }


  /* Create new math field */
  function createField() {
    let max = 0;
    $('.mq-editable-field').each(function(){
        if($( this ).hasClass('mq-focused') ) {
            activeID =  $( this ).attr('id');
        }
        let id =  $( this ).attr('id');
        let idnum = parseInt(id.slice(-1));
        if (idnum>=max) {
            max=idnum;
        }
    });
    totalFields = max;
    console.log(max);
    activeID = "math-field"+String(Math.max(1,totalFields));
    console.log(activeID);

    $('<div class="dragdiv" id="dragdiv' + String(totalFields+1) +'"><div class="dragdivheader" id="dragdivheader' + String(totalFields+1) + '"><div class="math-field" id="math-field' + String(totalFields+1) + '"></div></div></div>').insertAfter( $( "#" + activeID.replace("math-field","dragdiv") ) );
    //$( '<p>Math field' + String(totalFields+1) + ': <span class="math-field" id="math-field' + String(totalFields+1) +'"></span></p>' ).insertAfter( $( "#" + activeID ) );
        $( '<p>LaTeX field' + String(totalFields+1) + ': <span id="latex' + String(totalFields+1) +'"></span></p>' ).insertAfter( $( "#" + activeID.replace("math-field","latex") ) );
        var varName = "mathFieldSpan" + String(totalFields+1);
        varName = document.getElementById('math-field' + String(totalFields+1));

        var varNameLatex = "latexSpan" + String(totalFields+1);
        varNameLatex  = document.getElementById('latex'+ String(totalFields+1))

        var varNameField = "mathField" + String(totalFields+1);
        varNameField = MQ.MathField(varName, {
            spaceBehavesLikeTab: true, // configurable
            handlers: {
              edit: function () {
                // useful event handlers
                varNameLatex.textContent = varNameField.latex() // simple API
              }
            }
          })
          varNameField.focus();
          dragElement(document.getElementById("dragdiv" + String(totalFields+1)));
          let top = parseInt(toppx+40);
          $('#dragdiv' + String(totalFields+1)).css({ top: String(top)+'px' });
          $('#dragdiv' + String(totalFields+1)).css({ left: leftpx+'px' });
    }
  