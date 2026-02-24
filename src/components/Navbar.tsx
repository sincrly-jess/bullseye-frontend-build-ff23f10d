import { Button } from "@/components/ui/button";
import bullseyeLogo from "@/assets/bullseye-logo.png";

const Navbar = () => {
  return (
    <nav className="fixed top-0 left-0 right-0 z-50 glass border-b border-border">
      <div className="container mx-auto flex items-center justify-center h-16 px-4 relative">
        {/* Centered Logo */}
        <img src={bullseyeLogo} alt="Bullseye" className="h-14 object-contain" />

        {/* Sign In button - absolute right */}
        <div className="absolute right-4">
          <Button size="sm" className="bg-primary text-primary-foreground hover:bg-primary/90">
            Sign In
          </Button>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
