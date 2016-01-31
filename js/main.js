$(document).ready(function () {

    /**
    *   Variables
    */

    // We declare the variables here for faster iteration

    var $signin = $('.play-button');
    var $signinForm = $('.signin-form');
    var $key = $('.key');
    var $letterInput = $('.letter');
    var $letterSubmit = $('.btn-letter');
    var $submitForm = $('.form-letter');
    var $usedLetters = $('.used-letters');
    var $modal = $('#info-modal');
    var _usedLetters = [];

    /**
     *   Functions
     */

    // Function that sets the used letters from the printed li elements

    function setUsedLetters() {
        _usedLetters = $usedLetters.text().replace(/\s+/g, '').split('');
    }

    // Function that disables the letters that have been used

    function disableUsedLetters(usedLetters) {
        usedLetters.forEach(function(usedLetter){
            $( ".key:contains(" + usedLetter+ ")" ).addClass('disabled');
        });
    }

    // Function that checks if a letter has been used

    function checkIfIsUsedLetter(testLetter) {
        if (!(_usedLetters.indexOf(testLetter) === -1)) {
            return true;
        } else {
            return false;
        }
    }

    function openModal(hasWon) {
        var title = '';

        if (hasWon) {
            title = 'Congratulations you won!';
        } else {
            title = 'Sorry you lost. Be cleverer the next time';
        }

        // Open Modal
        $modal.modal('show');
    }

    /**
     * Sign In Functionality
     **/

    // When the user clicks on signin button
    // open the signin form

    $signin.click(function () {
        if ($signinForm.hasClass('open')) {

            $signinForm.removeClass('open');

        } else {

            $signinForm.addClass('open');

        }
    });

    /**
    * Keyboard Functionality
    **/

    setUsedLetters();
    disableUsedLetters(_usedLetters);

    // Add the letter to the input on KeyDown

    $(window).keydown(function(e) {
        var key = (e.keyCode) ? e.keyCode : e.which;
        var $key = $('.key.k' + key);
        var letter = $key.text();

        // If the key pressed is Enter submit the input
        if (key === 13) {
            e.preventDefault();
            $letterSubmit.click();
            return;
        }

        // Check if the letter has been used or not and put it in the input
        if (!checkIfIsUsedLetter(letter)) {
            $key.addClass('active');
            $letterInput.val(letter);
        }

    });

    $(window).keyup(function(e) {
        var key = (e.keyCode) ? e.keyCode : e.which;
        $('.key.k' + key).removeClass('active');
    });

    // Add the letter to the input on Click

    $key.click(function(){
        var letter = this.textContent;

        if (!checkIfIsUsedLetter(letter)) {
            $letterInput.val(letter);
        }
    });

    // Don't allow the used letters to be set in the input manually

    // On Keypress
    $letterInput.keypress(function(key) {
        var keyLetter = String.fromCharCode(key);

        if (_usedLetters.indexOf(keyLetter)) {
            return false;
        };
    });

    // On Autocomplete
    $letterInput.on('input', function(){
        var keyLetter = $letterInput.val();
        if (_usedLetters.indexOf(keyLetter)) {
            $letterInput.val('');
        };
    });

    // Don't allow empty value to be posted back

    $letterSubmit.click( function(e) {
        if ($letterInput.val() === '') {
            e.preventDefault();
        }
    });

    /**
    *   Modal with state
    */
    // Check if the game has ended and open the modal
    if (gameEnd) {
        openModal(hasWon);
    }

    if (isModalOpened) {
        $modal.modal('show');
    }

//-->jQuery End
});
