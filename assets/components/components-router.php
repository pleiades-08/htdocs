<?php
// components-router.php
class ComponentRouter {
  private $components = [
    'header' => '../assets/components/header.php', //header component
    'sidebar' => '../assets/components/sidebar.php', //sidebar component
    'navbar' => '../assets/components/navbar.php', //navbar component for student
    'eval_fields' => '../assets/components/eval_fields.php', //navbar component for faculty
    'anavbar' => '../assets/components/anavbar.php', //navbar component for admin
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