<script>
    // Abre menu sidebar    
    function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
    }        
</script>
</body>
</html>

<?php $_SESSION['token'] = $_COOKIE['token']; ?>
