<script src="<?php echo PEADEX; ?>assets/cli/js/jquery-1.12.0.js" type="text/javascript"></script>
<script src="<?php echo PEADEX; ?>assets/cli/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo PEADEX; ?>assets/cli/js/custom.js" type="text/javascript"></script>
<script src="<?php echo PEADEX; ?>assets/cli/js/datetimepicker.js" type="text/javascript"></script>

<!-- Modern theme JS includes removed as per revert request -->

<script>
    // Modern JavaScript functions (no jQuery dependency)
    function Viewmap() {
        const viewmapElement = document.querySelector(".viewmap");
        if (viewmapElement) {
            viewmapElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function gototop(id) {
        const targetElement = document.querySelector('.' + id);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {

        // Sticky header functionality
        const navbar = document.querySelector('.sticky');
        if (navbar) {
            window.addEventListener('scroll', function() {
                if (window.innerWidth > 960) {
                    if (window.pageYOffset > 156) {
                        navbar.classList.add("fixed-nav");
                    } else {
                        navbar.classList.remove("fixed-nav");
                    }
                } else {
                    navbar.classList.remove("fixed-nav");
                }
            });
        }

        // Back to top functionality
        const backTop = document.getElementById("back-top");
        if (backTop) {
            // Hide back-top initially
            backTop.style.display = 'none';

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 100) {
                    backTop.style.display = 'block';
                    backTop.style.opacity = '1';
                } else {
                    backTop.style.opacity = '0';
                    setTimeout(() => {
                        if (backTop.style.opacity === '0') {
                            backTop.style.display = 'none';
                        }
                    }, 300);
                }
            });

            // Scroll to top on click
            const backTopLink = backTop.querySelector('a');
            if (backTopLink) {
                backTopLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        }
    });

    function indexto() {
        const x = confirm("Please Create a Booking Using Software.");
        if (x) {
            window.location.href = "<?php echo PEADEX; ?>";
            return true;
        } else {
            return false;
        }
    }

    function gotopage(id) {
        window.location.href = "<?php echo PEADEX; ?>" + id;
    }
</script>