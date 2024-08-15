<div class="lokasi-container">
    <h2>LOKASI PKBI</h2>
    <div class="lokasi-content">
        <?php foreach ($klinik as $data) { ?>
            <div class="lokasi-item">
                <img src="<?= base_url('asset/foto_klinik/') . htmlspecialchars($data['foto'], ENT_QUOTES, 'UTF-8'); ?>" alt="Klinik <?= htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="lokasi-info">
                    <h4><?= htmlspecialchars($data['klinik'], ENT_QUOTES, 'UTF-8'); ?></h4>
                    <p><?= htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Nomor Telepon: <?= htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8'); ?></p>

                    <button class="profil-btn-klinik openModal"
                        data-klinik="<?= htmlspecialchars($data['klinik'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-alamat="<?= htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-phone="<?= htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-provinsi="<?= htmlspecialchars($data['provinsi'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-kabupaten=" <?= htmlspecialchars($data['kabupaten'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-kecamatan=" <?= htmlspecialchars($data['kecamatan'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-kelurahan=" <?= htmlspecialchars($data['kelurahan'], ENT_QUOTES, 'UTF-8'); ?> ">Profil & Layanan</button>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class=" pagination">
        <?= $pagination; ?>
    </div>

    <div id="profilModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalKlinikName">Klinik Name</h2>
            <p id="modalKlinikAlamat">Alamat</p>
            <p id="modalKlinikPhone">Nomor Telepon</p>
            <p id="modalKlinikProvinsi">Provinsi</p>
            <p id="modalKlinikKabupaten">Kabupaten</p>
            <p id="modalKlinikKecamatan">Kecamatan</p>
            <p id="modalKlinikKelurahan">Kelurahan</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById("profilModal");
            var btns = document.querySelectorAll(".profil-btn-klinik");
            var span = document.querySelector(".modal .close");

            // Function to open the modal and update its content
            function openModal() {
                var klinikName = this.getAttribute("data-klinik");
                var klinikAlamat = this.getAttribute("data-alamat");
                var klinikPhone = this.getAttribute("data-phone");
                var klinikProvinsi = this.getAttribute("data-provinsi");
                var KlinikKabupaten = this.getAttribute("data-kabupaten");
                var KlinikKecamatan = this.getAttribute("data-kecamatan");
                var KlinikKelurahan = this.getAttribute("data-kelurahan");


                document.getElementById("modalKlinikName").textContent = "Nama :" + klinikName;
                document.getElementById("modalKlinikAlamat").textContent = "Alamat :" + klinikAlamat;
                document.getElementById("modalKlinikPhone").textContent = "Nomor Telepon: " + klinikPhone;
                document.getElementById("modalKlinikProvinsi").textContent = "Provinsi :" +
                    klinikProvinsi;
                document.getElementById("modalKlinikKabupaten").textContent = "Kabupaten : " + KlinikKabupaten;
                document.getElementById("modalKlinikKecamatan").textContent = "Kecamatan : " + KlinikKecamatan;
                document.getElementById("modalKlinikKelurahan").textContent = "Kelurahan :" + KlinikKelurahan;


                modal.style.display = "block";
            }

            // Function to close the modal
            function closeModal() {
                modal.style.display = "none";
            }

            // Attach click event listener to each "Profil & Layanan" button
            btns.forEach(function(btn) {
                btn.addEventListener('click', openModal);
            });

            // Close the modal when the user clicks on <span> (x)
            if (span) {
                span.addEventListener('click', closeModal);
            }

            // Close the modal if the user clicks anywhere outside of it
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    closeModal();
                }
            });
        });
    </script>
</div>