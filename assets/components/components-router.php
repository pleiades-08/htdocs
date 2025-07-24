<?php
// components-router.php
class ComponentRouter {
  private $components = [
    'header' => '../assets/components/header.php',
    'sidebar' => '../assets/components/sidebar.php',
    'navbar' => '../assets/components/navbar.php',
    'fnavbar' => '../assets/components/fnavbar.php',
  ];

  public function load($componentName) {
    if (isset($this->components[$componentName])) {
      include($this->components[$componentName]);
    } else {
      echo "<!-- Component {$componentName} not found -->";
    }
  }
}

// Initialize in your main file
$componentRouter = new ComponentRouter();
?>