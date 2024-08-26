<section class="section">
	<div class="card">
		<div class="card-body">
			<?php if (strpos($file, '.pdf') !== false) { ?>
				<embed src="<?php echo base_url('file/proposal/' . $folder . '/' . $file); ?>" type="application/pdf" width="100%" height="600px" />
			<?php } else { ?>
				<img src="<?php echo base_url('file/proposal/' . $folder . '/' . $file); ?>" alt="Image" class="img-fluid" />
			<?php } ?>
		</div>
	</div>
</section>