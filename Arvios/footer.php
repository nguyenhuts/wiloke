
			    <!-- FOOTER -->
			    <footer id="footer" class="footer">
			        <div class="container">
			            <div class="scroll-top">
			                <i class="fa fa-angle-up"></i>
			            </div>
			            <?php pi_social(); ?>
			        </div>
			        <?php if ( isset(piThemeOptions::$piOptions['footer']['copyright']) && !empty(piThemeOptions::$piOptions['footer']['copyright']) ) : ?>
						<p class="copyright text-uppercase text-center"><?php echo wp_unslash(piThemeOptions::$piOptions['footer']['copyright']); ?></p>
			        	<?php endif; ?>
			    </footer>
			   
			    <!-- END / FOOTER -->
			</div>
		<?php wp_footer(); ?>
	</body>
</html>
