<?php
session_start();
require_once "../core/Auth.php";
require_once "../config/database.php";
require_once __DIR__ . "/profile_config.php";

Auth::cekLogin();

$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$targetUsername = $_SESSION['username'] ?? '';
if ($isAdmin && isset($_GET['username'])) {
    $candidate = trim((string) $_GET['username']);
    if ($candidate !== '' && preg_match('/^[a-zA-Z0-9_.-]+$/', $candidate)) {
        $targetUsername = $candidate;
    }
}

$updateErrors = $_SESSION['profile_errors'] ?? [];
$updateSuccess = $_SESSION['profile_success'] ?? "";
unset($_SESSION['profile_errors'], $_SESSION['profile_success']);

$profile = [];
$photoSrc = "/4pti2/assets/default_profile.jpg";
$ttlValue = "";
$bpjsValue = "";
$gajiDisplay = "Tersembunyi";
$jabatanName = "";

try {
    $db = new Database();
    $stmt = $db->conn->prepare(
        "SELECT p.*, j.namajab FROM tbl_pegawai p LEFT JOIN tbl_jabatan j ON p.idjabatan = j.id WHERE p.username = ? LIMIT 1"
    );
    if ($stmt) {
        $stmt->bind_param("s", $targetUsername);
        $stmt->execute();
        $profile = $stmt->get_result()->fetch_assoc() ?: [];
        $stmt->close();
    }
} catch (Exception $e) {
    $profile = [];
}

$tempatLahir = trim($profile['tempat_lahir'] ?? "");
$tanggalLahir = trim($profile['tanggallahir'] ?? "");
if ($tempatLahir !== "" && $tanggalLahir !== "") {
    $ttlValue = $tempatLahir . " - " . $tanggalLahir;
} else {
    $ttlValue = $tempatLahir !== "" ? $tempatLahir : $tanggalLahir;
}

$bpjsKesehatan = trim($profile['bpjs_kesehatan'] ?? "");
$bpjsKetenagakerjaan = trim($profile['bpjs_ketenagakerjaan'] ?? "");
if ($bpjsKesehatan !== "" && $bpjsKetenagakerjaan !== "") {
    $bpjsValue = "Kesehatan: " . $bpjsKesehatan . ", Ketenagakerjaan: " . $bpjsKetenagakerjaan;
} elseif ($bpjsKesehatan !== "") {
    $bpjsValue = "Kesehatan: " . $bpjsKesehatan;
} elseif ($bpjsKetenagakerjaan !== "") {
    $bpjsValue = "Ketenagakerjaan: " . $bpjsKetenagakerjaan;
}

$jabatanName = trim($profile['namajab'] ?? "");
if ($jabatanName === "") {
    $jabatanName = trim($profile['jabatan'] ?? "");
}

$gajiPokok = $profile['gaji_pokok'] ?? "";
if ($gajiPokok !== "" && $gajiPokok !== null) {
    $gajiDisplay = "Rp " . number_format((float) $gajiPokok, 0, ",", ".");
}

$fotoProfil = trim($profile['foto_profil'] ?? "");
if ($fotoProfil !== "") {
    if (strpos($fotoProfil, "http") === 0 || strpos($fotoProfil, "/") === 0) {
        $photoSrc = $fotoProfil;
    } else {
        $photoSrc = "/4pti2/" . ltrim($fotoProfil, "/");
    }
}

function display_value($value, $fallback = "Belum diisi")
{
    $text = trim((string) $value);
    if ($text === "") {
        return htmlspecialchars($fallback, ENT_QUOTES, 'UTF-8');
    }
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function get_profile_value($row, $profile, $ttlValue, $bpjsValue, $jabatanName, $gajiDisplay)
{
    $source = $row['source'] ?? 'profile';
    if ($source === 'ttl') {
        return $ttlValue;
    }
    if ($source === 'bpjs') {
        return $bpjsValue;
    }
    if ($source === 'jabatan') {
        return $jabatanName;
    }
    if ($source === 'gaji') {
        return $gajiDisplay;
    }
    $field = $row['field'] ?? '';
    return $field !== '' ? ($profile[$field] ?? '') : '';
}

$profileJson = json_encode($profile, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
if ($profileJson === false) {
    $profileJson = "{}";
}
$editConfigJson = json_encode($editConfig, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
if ($editConfigJson === false) {
    $editConfigJson = "{}";
}
?>
<?php require_once "../layout/header.php"; ?>
<?php require_once "../layout/sidebar.php"; ?>

<main class="content">
    <div class="profile-page">
        <?php if (count($updateErrors) > 0): ?>
            <div class="profile-alert profile-alert-error">
                <?php foreach ($updateErrors as $error): ?>
                    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($updateSuccess !== ""): ?>
            <div class="profile-alert profile-alert-success">
                <p><?= htmlspecialchars($updateSuccess, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endif; ?>

        <div class="profile-hero">
            <div>
                <h1>Profil Karyawan</h1>
                <p>Lengkapi dan perbarui data profil Anda.</p>
            </div>
        </div>

        <?php foreach ($profileSections as $section): ?>
            <section class="profile-section">
                <div class="section-title"><?= htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="profile-grid">
                    <?php foreach ($section['rows'] as $row): ?>
                        <?php
                        $rowType = $row['type'] ?? 'text';
                        $rowValue = get_profile_value($row, $profile, $ttlValue, $bpjsValue, $jabatanName, $gajiDisplay);
                        $fallback = $row['fallback'] ?? 'Belum diisi';
                        ?>
                        <div class="profile-row <?= $rowType === 'photo' ? 'profile-photo-row' : ''; ?>">
                            <div class="profile-label"><?= htmlspecialchars($row['label'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="profile-value">
                                <?php if ($rowType === 'photo'): ?>
                                    <img src="<?= htmlspecialchars($photoSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="Foto profil"
                                        class="profile-photo">
                                <?php else: ?>
                                    <?= display_value($rowValue, $fallback) ?>
                                <?php endif; ?>
                            </div>
                            <button class="profile-edit" type="button"
                                data-edit="<?= htmlspecialchars($row['editKey'], ENT_QUOTES, 'UTF-8'); ?>"
                                aria-label="Edit <?= htmlspecialchars($row['label'], ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </div>
</main>

<div class="profile-modal" id="profileModal" aria-hidden="true">
    <div class="profile-modal-content" role="dialog" aria-modal="true" aria-labelledby="profileModalTitle">
        <div class="profile-modal-header">
            <h2 id="profileModalTitle">Edit Data</h2>
            <button class="profile-modal-close" type="button" id="profileModalClose" aria-label="Tutup">&times;</button>
        </div>
        <form class="profile-modal-body" id="profileForm" action="profile_update.php" method="post"
            enctype="multipart/form-data">
            <input type="hidden" name="edit_key" id="editKey" value="">
            <input type="hidden" name="target_username"
                value="<?= htmlspecialchars($targetUsername, ENT_QUOTES, 'UTF-8'); ?>">
            <div id="profileFields"></div>
            <div class="profile-modal-actions">
                <button class="profile-modal-cancel" type="button" id="profileModalCancel">Batal</button>
                <button class="profile-modal-save" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const profileData = <?= $profileJson; ?>;
    const editConfig = <?= $editConfigJson; ?>;

    const modal = document.getElementById("profileModal");
    const modalTitle = document.getElementById("profileModalTitle");
    const modalClose = document.getElementById("profileModalClose");
    const modalCancel = document.getElementById("profileModalCancel");
    const fieldsContainer = document.getElementById("profileFields");
    const editKeyInput = document.getElementById("editKey");

    function openModal(key) {
        const config = editConfig[key];
        if (!config) {
            return;
        }
        modalTitle.textContent = config.title;
        editKeyInput.value = key;
        fieldsContainer.innerHTML = "";

        config.inputs.forEach((inputConfig) => {
            const field = document.createElement("div");
            field.className = "profile-field";

            const label = document.createElement("label");
            label.textContent = inputConfig.label;

            let inputEl;
            if (inputConfig.type === "textarea") {
                inputEl = document.createElement("textarea");
                inputEl.rows = 3;
            } else {
                inputEl = document.createElement("input");
                inputEl.type = inputConfig.type;
            }

            inputEl.name = inputConfig.name;
            if (inputConfig.accept) {
                inputEl.accept = inputConfig.accept;
            }
            if (inputConfig.step) {
                inputEl.step = inputConfig.step;
            }
            if (inputConfig.type !== "file") {
                inputEl.value = profileData[inputConfig.name] || "";
            }

            field.appendChild(label);
            field.appendChild(inputEl);
            fieldsContainer.appendChild(field);
        });

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
    }

    function closeModal() {
        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        fieldsContainer.innerHTML = "";
    }

    document.querySelectorAll(".profile-edit").forEach((button) => {
        button.addEventListener("click", () => {
            openModal(button.dataset.edit);
        });
    });

    modalClose.addEventListener("click", closeModal);
    modalCancel.addEventListener("click", closeModal);
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
</script>

<?php require_once "../layout/footer.php"; ?>