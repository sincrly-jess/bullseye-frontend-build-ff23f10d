import { Button } from "@/components/ui/button";

const Navbar = () => {
  return (
    <nav className="fixed top-0 left-0 right-0 z-50 glass border-b border-border">
      <div className="container mx-auto flex items-center justify-center h-16 px-4 relative">
        {/* Centered Logo */}
        <div className="flex items-center gap-2">
          <div className="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
            <span className="font-display text-primary-foreground text-sm font-bold">B</span>
          </div>
          <span className="font-display text-lg font-bold tracking-wider text-foreground">
            BULLSEYE
          </span>
        </div>

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
