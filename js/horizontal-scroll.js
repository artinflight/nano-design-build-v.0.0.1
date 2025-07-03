document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.horizontal-scroll-container');
    const scrollTrack = document.querySelector('.scroll-track');
    if (!scrollContainer || !scrollTrack) return;

    let scrollContainerOffsetTop = 0;
    let scrollLimit = 0;
    let containerHeight = 0;
    
    function calculateDimensions() {
        scrollContainerOffsetTop = scrollContainer.offsetTop;
        scrollLimit = scrollTrack.scrollWidth - window.innerWidth;
        containerHeight = scrollLimit;
        
        // Set the height of the container that creates the vertical scroll space
        document.querySelector('.horizontal-scroll-end-spacer').style.height = `${containerHeight}px`;
    }
    
    function handleScroll() {
        const scrollTop = window.scrollY;

        // Check if the user has scrolled to where the sticky container begins
        if (scrollTop >= scrollContainerOffsetTop) {
            // Calculate how far into the sticky section we have scrolled
            let horizontalScroll = scrollTop - scrollContainerOffsetTop;
            
            // Make sure we don't scroll past the limit
            if (horizontalScroll > scrollLimit) {
                horizontalScroll = scrollLimit;
            }

            // Apply the horizontal transform
            scrollTrack.style.transform = `translateX(-${horizontalScroll}px)`;
        } else {
            // Reset transform if we are scrolled above the sticky section
            scrollTrack.style.transform = 'translateX(0px)';
        }
    }

    // Initial calculation and event listeners
    calculateDimensions();
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resize', calculateDimensions);
});