                <?php get_sidebar(); ?>
            </div>
            <a href="#wrapper" id="backBtn" class="btn btn-primary rounded-circle btn-backToContent d-none">
                <span class="visually-hidden">Wróć na początek strony</span>
                <i class="fas fa-arrow-up" aria-hidden="true"></i>
            </a>
            <footer class="text-light py-3" id="footer" role="contentinfo">
                <div class="container text-center" id="copyright">
                    &copy; <?php echo esc_html( date_i18n( __( 'Y', 'frontenddev' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                </div>
            </footer>
        </div>

        <?php wp_footer(); ?>
        
    </body>
</html>